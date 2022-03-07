<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use ForestCollection;

    /**
     * @return array
     */
    public function searchFields(): array
    {
        return [
            'reference',
            'model',
            'brand',
            'year',
            'category_id',
            'manual',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function check(): BelongsToMany
    {
        return $this->belongsToMany(Check::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(booking::class);
    }
}
