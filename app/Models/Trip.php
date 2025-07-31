<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\TripFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $car_id
 * @property int $user_id
 * @property CarbonInterface $start_time
 * @property CarbonInterface $end_time
 *
 * @property-read Car $car
 * @property-read User $user
 *
 * @property-read CarbonInterface|null $created_at
 * @property-read CarbonInterface|null $updated_at
 */
class Trip extends Model
{
    protected $table = 'trips';

    protected $fillable = [
        'car_id',
        'user_id',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public static function factory(): TripFactory
    {
        return new TripFactory();
    }
}