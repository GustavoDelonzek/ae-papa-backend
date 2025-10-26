<?php

namespace App\Jobs;

use App\Enums\EnumStatusDocument;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Document;
use Illuminate\Support\Facades\Log;
use Throwable;

use Google\Cloud\Storage\StorageClient;

class UploadDocumentToGcp implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 120;

    public array $backoff = [10, 30];

    public function __construct(
        private Document $document,
        private string $fileContent,
    ) {
        //
    }

    public function handle(): void
    {
        Log::info("[DEPURAÇÃO] Iniciando handle() do UploadDocumentToGcp. Documento ID: {$this->document->id}. Tentativa: {$this->attempts()}");

        $keyFilePath = null;
        $bucketName = null;

        try {

            $keyFileConfig = env('GCS_KEY_FILE');
            if (!$keyFileConfig) {
                throw new \Exception("Variável GCS_KEY_FILE não está definida no .env do worker.");
            }

            $keyFilePath = storage_path($keyFileConfig);
            $bucketName = env('GCS_BUCKET');

            Log::info("[DEPURAÇÃO] Tentando carregar a chave de: " . $keyFilePath);
            Log::info("[DEPURAÇÃO] Tentando usar o bucket: " . $bucketName);

            $storage = new StorageClient([
                'keyFilePath' => $keyFilePath,
            ]);

            Log::info("[DEPURAÇÃO] StorageClient inicializado com sucesso.");

            $bucket = $storage->bucket($bucketName);
            $bucket->upload(
                base64_decode($this->fileContent, true),
                [
                    'name' => $this->document->file_path
                ]
            );

            Log::info("[DEPURAÇÃO] Upload concluído! Documento ID: {$this->document->id}");
            $this->document->update(['status' => EnumStatusDocument::COMPLETED->value]);

            //TODO: adicionar broadcast/event para notificar upload concluído para o front-end
        } catch (Throwable $e) {
            $errorMessage = $e->getMessage();
            Log::error("==================================================================");
            Log::error("[DEPURAÇÃO] FALHA NA TENTATIVA (Job UploadDocumentToGcp):");
            Log::error("Documento ID: {$this->document->id}");
            Log::error("Tentativa atual: " . $this->attempts());
            Log::error("Caminho da Chave: " . ($keyFilePath ?? 'Não carregado'));
            Log::error("Mensagem de Erro: " . $errorMessage);
            Log::error("Stack Trace: " . $e->getTraceAsString());
            Log::error("==================================================================");


            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        $this->document->update(['status' => EnumStatusDocument::FAILED->value]);
        Log::error("[DEPURAÇÃO] MÉTODO FAILED() CHAMADO (TODAS AS TENTATIVAS FALHARAM) para Documento ID: {$this->document->id}");
        Log::error("[DEPURAÇÃO] Exceção final: " . $exception->getMessage());
    }
}
