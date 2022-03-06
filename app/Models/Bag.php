<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'image',
        'count'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ],
        ];
    }

    /**
     * Получить все заказы, связанные с товаром
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
