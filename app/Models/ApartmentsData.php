<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Request;

/**
 * Данные по квартирам
 * @property integer chat_id
 * @property integer msg_id
 * @property string title
 * @property string address
 * @property string full_address
 * @property float lat
 * @property float lng
 * @property string status
 * @property integer price
 * @property string full_price
 * @property string pets_allowed
 * @property string kids_allowed
 * @property string advantages
 * @property string type
 * @property integer number_of_rooms
 * @property string created_at
 * @property string updated_at
 *
 */
class ApartmentsData extends Model
{
    use HasFactory;
//    use SoftDeletes;

    protected $fillable = [
        'chat_id',
        'msg_id',
        'title',
        'address',
        'full_address',
        'lat',
        'lng',
        'status',
        'price',
        'full_price',
        'pets_allowed',
        'kids_allowed',
        'advantages',
        'type',
        'number_of_rooms',
        'photo',
        'created_at',
        'updated_at',
    ];

    /**
     * Минимальное значение стоимости квартиры в долларах в фильтре
     * @var int
     */
    protected static int $min = 300;

    /**
     * Максимальное значение стоимости квартиры в долларах в фильтре
     * @var int
     */
    protected static int $max = 2000;

    /**
     * Scope для фильтра
     * @param Builder $builder
     * @param QueryFilter $filters
     * @return Builder
     */
    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }

    /**
     * @return array
     */
    public static function getMinMaxPrice(): array
    {
        if (strpos(Request::query('price'), ',')) {
            list(self::$min, self::$max) = explode(',', Request::query('price'));
        }

        return [self::$min, self::$max];
    }
}
