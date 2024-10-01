<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingTransaction extends Model
{
    use HasFactory;

    protected $casts = [
        'started_at' => 'date'
    ];

    public static function generateUniqueTrxId()
    {
        $prefix = 'CC';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('trx_id', $randomString)->exists());
        return $randomString;
    }

    public function carService(): BelongsTo
    {
        return $this->belongsTo(CarService::class);
    }

    public function carStore(): BelongsTo
    {
        return $this->belongsTo(CarStore::class);
    }
}
