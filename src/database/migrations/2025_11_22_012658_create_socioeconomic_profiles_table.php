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
        Schema::create('socioeconomic_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->json('income_source')->nullable();
            $table->string('housing_ownership')->nullable();
            $table->string('construction_type')->nullable();
            $table->json('sanitation_details')->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->integer('number_of_residents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socioeconomic_profiles');
    }
};
