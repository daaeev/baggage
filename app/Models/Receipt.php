<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    /**
     * Получить пользователя данного чека
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить товар данного чека
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bag()
    {
        return $this->belongsTo(Bag::class);
    }
}
