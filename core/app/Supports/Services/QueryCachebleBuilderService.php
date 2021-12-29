<?php

namespace App\Supports\Services;

use Carbon\Carbon;
use Rennokki\QueryCache\Query\Builder;

class QueryCachebleBuilderService extends Builder
{
    public function generatePlainCacheKey(string $method = 'get', $id = null, $appends = null): string
    {
        $name = $this->connection->getName();
        $bindings = $this->getBindings();
        $bindingsSanitized = $this->sanitizeBindings($bindings);

        // Count has no Sql, that's why it can't be used ->toSql()
        if ($method === 'count') {
            $key = $name . $method . $id . serialize($bindingsSanitized) . $appends;
        }

        $key = $name . $method . $id . $this->toSql() . serialize($bindingsSanitized) . $appends;

        return $key;
    }

    protected function sanitizeBindings($bindings)
    {
        $bindingsCollect = collect($bindings)->map(function ($item) {
            if ($item instanceof Carbon) {
                return 'carbon_datetime_replaced';
            }
            return $item;
        });

        return $bindingsCollect;
    }
}
