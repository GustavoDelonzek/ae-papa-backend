<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

use function PHPUnit\Framework\isNull;

class ContactFilter
{
    public function __construct(
        private readonly array|null $filters,
        private readonly Builder $contacts
    ) {
    }

    public function applyFilters(): Builder
    {
        $this->byType();
        $this->byValue();

        return $this->contacts;
    }

    public function byType()
    {
        if ($type = data_get($this->filters, 'type')) {
            $this->contacts->where('type', $type);
        }
    }

    public function byValue()
    {
        if ($value = data_get($this->filters, 'value')) {
            $this->contacts->where('value', $value);
        }
    }
}
