<?php

namespace App\Observers;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

// مراقب سجلات النشاط (Audit Logs) للعمليات المختلفة
class AuditObserver
{
    /**
     * معالجة حدث الإنشاء (Created)
     */
    public function created(Model $model): void
    {
        Activity::log(
            'created',
            'تم إنشاء سجل جديد في ' . class_basename($model),
            $model,
            $model->toArray()
        );
    }

    /**
     * معالجة حدث التحديث (Updated)
     */
    public function updated(Model $model): void
    {
        // Ignore updated_at changes only
        if ($model->wasChanged() && count($model->getChanges()) === 1 && $model->wasChanged('updated_at')) {
            return;
        }

        $properties = [
            'old' => [],
            'new' => [],
        ];

        foreach ($model->getChanges() as $key => $value) {
            $properties['old'][$key] = $model->getOriginal($key);
            $properties['new'][$key] = $value;
        }

        Activity::log(
            'updated',
            'تم تحديث سجل في ' . class_basename($model),
            $model,
            $properties
        );
    }

    /**
     * معالجة حدث الحذف (Deleted)
     */
    public function deleted(Model $model): void
    {
        Activity::log(
            'deleted',
            'تم حذف سجل من ' . class_basename($model),
            null, // Subject is gone, so maybe null or keep it if soft deletes (but subject_id stays)
            $model->toArray()
        );
    }
}
