<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('caregiver_patient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caregiver_id')->constrained('caregivers')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('kinship')->nullable();
            $table->timestamps();

            $table->unique(['caregiver_id', 'patient_id']);
        });

        DB::statement('
            INSERT INTO caregiver_patient (caregiver_id, patient_id, kinship, created_at, updated_at)
            SELECT id, patient_id, kinship, created_at, updated_at
            FROM caregivers
            WHERE patient_id IS NOT NULL
        ');

        Schema::table('caregivers', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn(['patient_id', 'kinship']);
        });
    }

    public function down(): void
    {
        Schema::table('caregivers', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->constrained('patients');
            $table->string('kinship')->nullable();
        });

        DB::statement('
            UPDATE caregivers c
            SET patient_id = (
                SELECT patient_id FROM caregiver_patient cp
                WHERE cp.caregiver_id = c.id
                LIMIT 1
            ),
            kinship = (
                SELECT kinship FROM caregiver_patient cp
                WHERE cp.caregiver_id = c.id
                LIMIT 1
            )
        ');

        Schema::dropIfExists('caregiver_patient');
    }
};
