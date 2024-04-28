<?php

namespace App;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DateModel extends Model
{
    public function scopeHasDate(
        Builder $query,
        $column,
        $date
    ): Builder
    {
        $start = (new CarbonImmutable())->setDateFrom($date)->startOfDay();
        $end = (new CarbonImmutable())->setDateFrom($date)->endOfDay();
        return $query
            ->where($column,  '>=', $start)
            ->where($column, '<=', $end);
    }
}
