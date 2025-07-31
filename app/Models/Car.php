<?php

namespace App\Models;

use App\Enums\ComfortCategoryEnum;
use Carbon\CarbonInterface;
use Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int|null $driver_id
 * @property string $model
 * @property ComfortCategoryEnum $comfort_category
 *
 * @property-read Driver|null $driver
 * @property-read Collection<Trip> $trips
 *
 * @property-read CarbonInterface|null $created_at
 * @property-read CarbonInterface|null $updated_at
 */
class Car extends Model
{
    protected $table = 'cars';

    protected $fillable = [
        'model',
        'driver_id',
        'comfort_category',
    ];

    protected $casts = [
        'comfort_category' => ComfortCategoryEnum::class,
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public static function factory(): CarFactory
    {
        return new CarFactory();
    }
}
