<?php

namespace App\Traits;

use App\Models\AuditLog;

trait Auditable
{
    protected static function bootAuditable()
    {
        // Log when a model is created
        static::created(function ($model) {
            AuditLog::logAction($model, 'created', null, $model->getAttributes());
        });

        // Log when a model is updated
        static::updated(function ($model) {
            $oldValues = $model->getOriginal();
            $newValues = $model->getChanges();
            
            AuditLog::logAction($model, 'updated', $oldValues, $newValues);
        });

        // Log when a model is deleted
        static::deleted(function ($model) {
            AuditLog::logAction($model, 'deleted', $model->getOriginal(), null);
        });
    }
}
