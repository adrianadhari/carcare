<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreService extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function carStore(): BelongsTo
    {
        return $this->belongsTo(CarStore::class, 'car_store_id');
    }

    public function storeService(): BelongsTo
    {
        return $this->belongsTo(CarService::class, 'car_service_id');
    }
}
