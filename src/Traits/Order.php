<?php

namespace Cdebattista\LaravelPermission\Traits;

trait Order{

    /**
     * Sort a table by a column asc/desc.
     *
     * @param [type] $query
     * @param string $column The name of the column to order by
     * @param string $order asc or desc
     * @return void
     */
    public function scopeOrder($query, $column, $order = 'asc')
    {
        if ($order !== 'asc') {
            $order = 'desc';
        }

        $query->orderBy($column, $order);
    }
}