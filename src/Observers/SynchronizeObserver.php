<?php

namespace Structure\Basic\Observers;

use Illuminate\Database\Eloquent\Model;
use Structure\Basic\Jobs\SynchronizeModelJob;

class SynchronizeObserver
{
    public function created(Model $model)
    {
        $modelName = class_basename($model);

        $data = [
            'ACTION'     => 'CREATE',
            'RESOURCE'   => $modelName,
            'PARAMETERS' => $model->toArray()
        ];

        SynchronizeModelJob::dispatch($data)->onQueue( strtolower( $modelName.'.create') );
    }

    public function updated(Model $model)
    {
        $modelName = class_basename($model);

        $data = [
            'ACTION'     => 'UPDATE',
            'RESOURCE'   => $modelName,
            'PARAMETERS' => $model->toArray()
        ];

        SynchronizeModelJob::dispatch($data)->onQueue( strtolower( $modelName.'.update') );
    }
}
