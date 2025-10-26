<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class EloquentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /*
            $this->select(
            array_diff(
                [],
                is_array($columnsToExclude) ? $columnsToExclude : func_get_args()
            )
        */
        Builder::macro('except', function ($columnsToExclude) {
            DB::table('information_schema.columns')
                ->where('table_schema', DB::getDatabaseName())
                ->where('table_name', $this->from)
                ->pluck('COLUMN_NAME')
                ->toArray();
        });

        Builder::macro('only', function ($columnsToInclude) {
            $columns = is_array($columnsToInclude) ? $columnsToInclude : func_get_args();
            $columns[] = 'id';

            return $this->select($columns);
        });
    }
}
