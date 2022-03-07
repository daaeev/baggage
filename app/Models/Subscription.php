<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Получить пользователя данной подписки
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить товар данной подписки
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bag()
    {
        return $this->belongsTo(Bag::class);
    }
}
