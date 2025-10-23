<?php

namespace App\Observers;

use App\Models\AuditLog;
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
            return; // não registra logs vazios
        }

        $payloadChanges = json_encode($changes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        AuditLog::create([
            'user_name'  => optional(Auth::user())->name ?? 'system',
            'action'     => $action,
            'model_type' => get_class($model),
            'model_id'   => $model->id,
            'changes'    => $payloadChanges,
        ]);
    }
}
