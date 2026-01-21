<?php

namespace App\Traits;

use App\Models\AuditLog;

trait Auditable
{
    public static function bootAuditable()
    {
        static::updating(function ($model) {
            $dirty = $model->getDirty();
            $original = $model->getOriginal();

            foreach ($dirty as $field => $newValue) {
                $oldValue = $original[$field] ?? null;

                if ($oldValue != $newValue) {
                    AuditLog::create([
                        'user_id'        => auth()->id(),
                        'auditable_type' => get_class($model),
                        'auditable_id'   => $model->getKey(),
                        'field'          => $field,
                        'old_value'      => $oldValue,
                        'new_value'      => $newValue,
                        'metadata'       => json_encode([
                            'url' => request()->fullUrl(),
                            'ip'  => request()->ip(),
                        ]),
                    ]);
                }
            }
        });
    }
}
