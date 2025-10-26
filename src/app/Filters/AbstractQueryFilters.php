<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;


abstract class AbstractQueryFilters
{
    protected ?array $filters;
    protected Builder $query;

    public function __construct(?array $filters, Builder $query)
    {
        $this->filters = $filters;
        $this->query = $query;
    }

    public function applyFilters(): Builder
    {
        if ($this->filters === null) {
            return $this->query;
        }

        foreach ($this->filters as $filterName => $value) {
            $methodName = Str::camel($filterName);

            if (method_exists($this, $methodName)) {
                $this->$methodName($value);
            }
        }

        return $this->query;
    }
}
