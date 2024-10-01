<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarStore extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }


    public function storePhotos(): HasMany
    {
        return $this->hasMany(StorePhoto::class);
    }

    public function storeServices(): HasMany
    {
        return $this->hasMany(StoreService::class);
    }
}
