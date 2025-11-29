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
        Schema::create('clinical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->date('diagnosis_date')->nullable();
            $table->string('disease_stage')->nullable();
            $table->json('comorbidities')->nullable();
            $table->string('responsible_doctor')->nullable();
            $table->string('health_unit_location')->nullable();
            $table->text('medications_usage')->nullable();
            $table->string('recognizes_family')->nullable();
            $table->string('emotional_state')->nullable();
            $table->boolean('wandering_risk')->default(false);
            $table->boolean('verbal_communication')->default(false);
            $table->boolean('disorientation_frequency')->default(false);
            $table->boolean('has_falls_history')->default(false);
            $table->boolean('needs_feeding_help')->default(false);
            $table->boolean('needs_hygiene_help')->default(false);
            $table->boolean('has_sleep_issues')->default(false);
            $table->boolean('has_hallucinations')->default(false);
            $table->boolean('reduced_mobility')->default(false);
            $table->boolean('is_aggressive')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_records');
    }
};
