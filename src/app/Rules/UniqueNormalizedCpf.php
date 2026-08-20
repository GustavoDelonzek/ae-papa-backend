<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UniqueNormalizedCpf implements ValidationRule
{
    public function __construct(
        private readonly string $table,
        private readonly mixed $ignore = null
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $digits = preg_replace('/\D/', '', (string) $value);

        if ($digits === '') {
            return;
        }

        $query = DB::table($this->table)
            ->whereRaw("regexp_replace(cpf, '\D', '', 'g') = ?", [$digits]);

        if ($ignoreId = $this->ignoreId()) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            $fail('Este CPF já está cadastrado.');
        }
    }

    private function ignoreId(): int|string|null
    {
        if ($this->ignore instanceof Model) {
            return $this->ignore->getKey();
        }

        return $this->ignore;
    }
}
