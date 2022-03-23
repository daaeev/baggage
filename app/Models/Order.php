<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Получить пользователя данного заказа
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить товар данного заказа
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bag()
    {
        return $this->belongsTo(Bag::class);
    }
}
