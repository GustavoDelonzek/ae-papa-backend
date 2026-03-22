<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;
use Throwable;
use Google\Cloud\Storage\StorageClient;

class UploadProfilePictureToGcp implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $timeout = 60;
    public array $backoff = [10, 30];

    public function __construct(
        private Patient $patient,
        private string $fileContent,
    ) {
    }

    public function handle(): void
    {
        Log::info("Iniciando upload da foto de perfil para o paciente ID: {$this->patient->id}.");

        try {
            $keyFileConfig = env('GCS_KEY_FILE');
            if (!$keyFileConfig) {
                throw new \Exception("Variável GCS_KEY_FILE não definida.");
            }

            $keyFilePath = storage_path($keyFileConfig);
            $bucketName = env('GCS_BUCKET');

            $storage = new StorageClient([
                'keyFilePath' => $keyFilePath,
            ]);

            $bucket = $storage->bucket($bucketName);
            
            $bucket->upload(
                base64_decode($this->fileContent, true),
                [
                    'name' => $this->patient->profile_picture_path,
                ]
            );

            Log::info("Upload da foto de perfil concluído para o paciente ID: {$this->patient->id}");

        } catch (Throwable $e) {
            Log::error("Falha no upload da foto de perfil para o paciente ID: {$this->patient->id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        Log::error("Todas as tentativas de upload da foto de perfil falharam para o paciente ID: {$this->patient->id}: " . $exception->getMessage());
    }
}
