<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->morphs('auditable');
            $table->enum('action', [
                'USER_LOGIN',
                'USER_LOGOUT',
                'USER_CREATED',
                'USER_UPDATED',
                'USER_DELETED',
                'PATIENT_CREATED',
                'PATIENT_UPDATED',
                'PATIENT_DELETED',
                'CAREGIVER_CREATED',
                'CAREGIVER_UPDATED',
                'CAREGIVER_DELETED',
                'APPOINTMENT_CREATED',
                'APPOINTMENT_UPDATED',
                'APPOINTMENT_DELETED',
                'DOCUMENT_UPLOADED',
                'DOCUMENT_DOWNLOADED',
                'DOCUMENT_DELETED'
            ]);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
