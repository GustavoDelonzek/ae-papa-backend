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
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->change();
            $table->foreignId('caregiver_id')->nullable()->after('patient_id')->constrained('caregivers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['caregiver_id']);
            $table->dropColumn('caregiver_id');
            $table->foreignId('patient_id')->nullable(false)->change();
        });
    }
};
