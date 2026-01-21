<?php

namespace App\Traits;

use App\Models\UserAction;
use Illuminate\Http\Request;

trait Crud
{
    const CREATE = 'create';

    const UPDATE = 'update';

    const SHOW = 'show';

    const DELETE = 'delete';

    public function cStore(Request $request)
    {
        $model = new $this->modelClass;
        $model = $this->modelClass::create($request->only($this->onlySaveFields($model)));
        $model = $this->attachTranslates($model, $request);
        $this->attachFiles($model, $request);
        // ✅ create qilganda ID bilan url saqlash
        $url = url(request()->route()->getPrefix().'/'.$model->getTable().'/'.$model->id);
        $this->saveUserAction($model, self::CREATE, $url);

        return $model;
    }

    public function cEdit($id)
    {
        return $this->modelClass::findOrFail($id);
    }

    public function cUpdate(Request $request, $id)
    {
        $model = $this->modelClass::findOrFail($id);
        // update qilishdan oldingi qiymatlar
        $oldValues = $model->getAttributes();

        $model->update($request->only($this->onlySaveFields($model)));
        $model = $this->attachTranslates($model, $request);
        $this->attachFiles($model, $request);
        // update qilingandan keyingi qiymatlar
        $newValues = $model->getAttributes();

        $this->saveUserAction($model, self::UPDATE, $oldValues, $newValues);

        return $model;
    }

    public function cDelete($id)
    {
        $model = $this->modelClass::findOrFail($id);

        if (isset($model->translatable)) {
            $model->deleteTranslations();
        }
        if (isset($model->fileFields)) {
            $model->deleteFiles();
        }
        $this->saveUserAction($model, self::DELETE);

        return $model->delete();
    }

    public function attachFiles($model, Request $request)
    {
        if (isset($model->fileFields)) {
            $model->attachFiles($request);
        }

        return $model;
    }

    public function attachTranslates($model, Request $request)
    {
        if (isset($model->translatable)) {
            foreach ($model->translatable as $field) {
                if (is_array($request->{$field})) {
                    $model->setTranslations($field, $request->{$field});
                } elseif (is_string($request->{$field})) {
                    $model->setTranslation($field, $request->{$field});
                }
            }
        }

        return $model;
    }

    public function onlySaveFields($model): array
    {
        $only = $model->getFillable();

        if (isset($model->fileFields)) {
            $only = array_diff($model->getFillable(), $model->fileFields);
        }
        if (isset($model->translatable)) {
            $only = array_diff($only, $model->translatable);
        }

        return $only;
    }

    protected function saveUserAction($model, $action, $oldValues = null, $newValues = null)
    {
        if ($action === self::CREATE) {
            $newValues = $model->getAttributes();
        }

        if ($action === self::DELETE) {
            $oldValues = $model->getAttributes();
        }

        if ($action === self::UPDATE) {
            $oldOriginal = $oldValues ?? $model->getOriginal();
            $newAttributes = $newValues ?? $model->getAttributes();

            $changesOld = [];
            $changesNew = [];

            foreach ($newAttributes as $key => $value) {
                if (array_key_exists($key, $oldOriginal) && $oldOriginal[$key] != $value) {
                    $changesOld[$key] = $oldOriginal[$key];
                    $changesNew[$key] = $value;
                }
            }

            // ⚡ Bo‘sh bo‘lsa ham JSON bo‘lib saqlash
            $oldValues = ! empty($changesOld) ? $changesOld : [];
            $newValues = ! empty($changesNew) ? $changesNew : [];
        }

        // url ni to‘g‘rilash (create/update/delete qaysi yozuv bo‘lsa, shu id bilan)
        $url = url('/'.trim(request()->route()->getPrefix(), '/').'/'.$model->getTable().'/'.$model->id);

        UserAction::create([
            'user_id' => auth()->user()?->id,
            'table_name' => $model->getTable(),
            'model_id' => $model->id,
            'action' => $action,
            'ip' => request()->ip(),
            'user_agent' => request()->header('User-Agent') ?: 'unknown', // yangi qo'shilgan
            'url' => $url,
            'route_name' => optional(request()->route())->getName(),
            'old_values' => $oldValues ? json_encode($oldValues, JSON_UNESCAPED_UNICODE) : null,
            'new_values' => $newValues ? json_encode($newValues, JSON_UNESCAPED_UNICODE) : null,
        ]);
    }
}
