<?php

namespace App\Models;

use App\Enums\ComfortCategoryEnum;
use Carbon\CarbonInterface;
use Database\Factories\PositionFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @property-read ComfortCategoryEnum[] $comfort_categories
 *
 * @property-read CarbonInterface|null $created_at
 * @property-read CarbonInterface|null $updated_at
 */
class Position extends Model
{
    protected $table = 'positions';

    protected $fillable = [
        'name',
        'comfort_categories',
    ];

    protected $casts = [
        'comfort_categories' => 'array',
    ];

    public static function factory(): PositionFactory
    {
        return new PositionFactory();
    }
}
