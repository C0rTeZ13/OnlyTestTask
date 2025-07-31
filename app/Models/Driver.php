<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\DriverFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 *
 * @property-read Car|null $car
 * @property-read Collection<Trip>|null $trips
 *
 * @property-read CarbonInterface|null $created_at
 * @property-read CarbonInterface|null $updated_at
 */
class Driver extends Model
{
    protected $table = 'drivers';

    protected $fillable = [
        'name',
    ];

    public function car(): HasOne
    {
        return $this->hasOne(Car::class, 'driver_id');
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }

    public static function factory(): DriverFactory
    {
        return new DriverFactory();
    }
}
