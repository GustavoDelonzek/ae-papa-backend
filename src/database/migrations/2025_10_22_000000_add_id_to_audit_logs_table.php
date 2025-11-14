<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// Não precisamos mais do 'use Illuminate\Support\Facades\DB;'

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    
        Schema::table('audit_logs', function (Blueprint $table) {
            
            if (! Schema::hasColumn('audit_logs', 'id')) {
                

                $table->id()->first();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            
            
            if (Schema::hasColumn('audit_logs', 'id')) {
                

                $table->dropColumn('id');
            }
        });
    }
};