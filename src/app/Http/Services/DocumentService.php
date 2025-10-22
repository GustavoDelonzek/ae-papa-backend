<?php

namespace App\Http\Services;

use App\Jobs\UploadDocumentToGcp;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Exception;
use Illuminate\Support\Facades\Log;

class DocumentService
{
    public function __construct() {
    }

    public function store(array $data): Document
    {
        $file = data_get($data, 'file');
        $fileNameFromUser = data_get($data, 'file_name');
        $extension = $file->getClientOriginalExtension();

        $safeFileName = Str::slug($fileNameFromUser) . Str::uuid(). '.' . $extension;

        $finalGcsPath = 'documents/patient_' . data_get($data, 'patient_id') . '/' . $safeFileName;

        $fileContent = $file->get();

        $encodedFileContent = base64_encode($fileContent);

        $documentData = Arr::except($data, ['file']);
        $documentData['status'] = 'pending';
        $documentData['file_name'] = $fileNameFromUser;
        $documentData['file_path'] = $finalGcsPath;
        $documentData['document_type'] = $data['document_type'] ?? null;
        $documentData['mime_type'] = $file->getClientMimeType();

        $document = Document::create($documentData);

        UploadDocumentToGcp::dispatch($document, $encodedFileContent);

        return $document;
    }

    public function deleteDocumentFromGcs(string $gcsPath): bool
    {
        try {
            if (Storage::disk('gcs')->exists($gcsPath)) {
                return Storage::disk('gcs')->delete($gcsPath);
            }
            Log::warning("Tentativa de deletar arquivo inexistente no GCS: {$gcsPath}");
            return true;

        } catch (Exception $e) {
            Log::error("Erro ao deletar arquivo do GCS em {$gcsPath}: " . $e->getMessage());
            return false;
        }
    }
}
