<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Enums\EnumActionAuditLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLogObserver
{
    /**
     * Quando um modelo é criado
     */
    public function created(Model $model)
    {
        $this->logChange('created', $model, $model->getAttributes());
    }

    /**
     * Quando um modelo é atualizado
     */
    public function updated(Model $model)
    {
        $this->logChange('updated', $model, $model->getChanges());
    }

    /**
     * Quando um modelo é deletado
     */
    public function deleted(Model $model)
    {
        $this->logChange('deleted', $model, $model->getOriginal());
    }

    /**
     * Quando um modelo é restaurado (soft delete)
     */
    public function restored(Model $model)
    {
        $this->logChange('restored', $model, $model->getAttributes());
    }

    /**
     * Função que realmente salva o log no banco
     */
    protected function logChange(string $action, Model $model, array $changes)
    {
        if (empty($changes)) {
            return; // don't record empty logs
        }

        // prefer enumized action when available, e.g. user_created, patient_updated
        $candidate = strtolower(class_basename($model) . '_' . $action);
        $enum = EnumActionAuditLogs::tryFrom($candidate);
        $actionValue = $enum?->value ?? $action;

        AuditLog::create([
            'user_name'  => optional(Auth::user())->name ?? 'system',
            'action'     => $actionValue,
            'model_type' => class_basename($model),
            'model_id'   => $model->id,
            'changes'    => $changes,
        ]);
    }
}
