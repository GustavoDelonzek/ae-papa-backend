<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\EnumStatusDocument;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('user_id')->constrained('users');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('document_type')->nullable();
            $table->string('mime_type');
            $table->string('description')->nullable();
            $table->string('status')->default(EnumStatusDocument::PENDING->value);
            $table->foreignId('appointment_id')->nullable()->constrained('appointments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
