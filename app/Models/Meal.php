<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rating' => 'float',
        'price' => 'float',
        'is_veg' => 'boolean'

    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = ['is_admin'];

    public function scopeFilter(Builder $query, array $filter): void
    {
        // dd($filter);
        $query->when(
            $filter['q'] ?? false,
            fn (Builder $query, string $search) => $query->where('name', 'like', '%' . $search . '%')
        );
    }

    /**
     * Determine if the user is an administrator.
     */
    // protected function isAdmin(): Attribute
    // {
    //     return new Attribute(
    //         get: fn () => 'yes',
    //     );
    // }
}
