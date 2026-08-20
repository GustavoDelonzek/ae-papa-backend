<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const TABLES = ['patients', 'caregivers'];

    private const NORMALIZED_CPF = "regexp_replace(cpf, '\D', '', 'g')";

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            $this->guardAgainstDuplicates($table);
        }

        foreach (self::TABLES as $table) {
            DB::statement(
                'create unique index ' . $this->indexName($table) .
                ' on ' . $table . ' ((' . self::NORMALIZED_CPF . '))'
            );
        }
    }

    public function down(): void
    {
        foreach (self::TABLES as $table) {
            DB::statement('drop index if exists ' . $this->indexName($table));
        }
    }

    private function indexName(string $table): string
    {
        return $table . '_cpf_normalized_unique';
    }

    private function guardAgainstDuplicates(string $table): void
    {
        $duplicates = DB::select(
            'select ' . self::NORMALIZED_CPF . ' as normalized, count(*) as total
             from ' . $table . '
             group by 1
             having count(*) > 1
             order by 2 desc'
        );

        if (empty($duplicates)) {
            return;
        }

        $details = collect($duplicates)
            ->map(fn ($row) => $row->normalized . ' (' . $row->total . 'x)')
            ->implode(', ');

        throw new RuntimeException(
            "Nao foi possivel criar o indice unico em {$table}: existem CPFs duplicados que precisam ser resolvidos antes. {$details}"
        );
    }
};
