<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;


    public function scopeFilter(Builder $query, array $filter) : void
    {
        // dd($filter);
        $query->when(
            $filter['q'] ?? false,
            fn (Builder $query, string $search) => $query->where('name', 'like', '%' . $search . '%')
        );
    }
}
