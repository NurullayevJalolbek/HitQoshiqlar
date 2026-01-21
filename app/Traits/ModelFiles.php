<?php

namespace App\Traits;

use App\Models\ModelFile;

trait ModelFiles
{
    public function files()
    {
        return $this->hasMany(ModelFile::class, 'model_id', 'id')
            ->where('table_name', $this->getTable());
    }
}
