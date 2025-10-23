<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            $exists = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name='audit_logs' AND column_name='id'");
            if (empty($exists)) {
                DB::statement('CREATE SEQUENCE IF NOT EXISTS audit_logs_id_seq;');
                DB::statement('ALTER TABLE audit_logs ADD COLUMN id bigint NOT NULL DEFAULT nextval(\'audit_logs_id_seq\');');
                DB::statement('ALTER SEQUENCE audit_logs_id_seq OWNED BY audit_logs.id;');
                DB::statement('ALTER TABLE audit_logs ADD PRIMARY KEY (id);');
            }
        } else {
            if (! Schema::hasColumn('audit_logs', 'id')) {
                Schema::table('audit_logs', function (Blueprint $table) {
                    $table->bigIncrements('id');
                });
            }
        }
    }

    public function down(): void
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            $exists = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name='audit_logs' AND column_name='id'");
            if (! empty($exists)) {
                DB::statement('ALTER TABLE audit_logs DROP CONSTRAINT IF EXISTS audit_logs_pkey;');
                DB::statement('ALTER TABLE audit_logs DROP COLUMN IF EXISTS id;');
                DB::statement('DROP SEQUENCE IF EXISTS audit_logs_id_seq;');
            }
        } else {
            if (Schema::hasColumn('audit_logs', 'id')) {
                Schema::table('audit_logs', function (Blueprint $table) {
                    $table->dropColumn('id');
                });
            }
        }
    }
};
