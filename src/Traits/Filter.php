<?php

namespace Cdebattista\LaravelPermission\Traits;

trait Filter {

    /**
     * Search filters.
     *
     * @param [type] $query
     * @param array $filters
     * @param array $searchColumns An array of column names that can be searched
     * @return void
     */
    public function scopeFilter($query, array $filters, array $searchColumns)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) use ($searchColumns) {
            $query->where(function ($query) use ($search, $searchColumns) {
                if (! empty($searchColumns)) {
                    $query->where(array_shift($searchColumns), 'like', '%'.$search.'%');
                    foreach ($searchColumns as $columnName) {
                        $query->orWhere($columnName, 'like', '%'.$search.'%');
                    }
                }
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}