<?php

namespace App\Models;

use App\Services\traits\RolesCheck;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, RolesCheck;

    /**
     * Константа используется в трейте RolesCheck
     * @var int числовое значение статуса админа
     */
    const STATUS_ADMIN = 5;

    /**
     * Константа используется в трейте RolesCheck
     * @var int числовое значение статуса забаненого пользователя
     */
    const STATUS_BANNED = 3;

    /**
     * Константа используется в трейте RolesCheck
     * @var int числовое значение статуса обычного пользователя
     */
    const STATUS_USER = 0;

    protected $attributes = [
        'status' => 0,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Получить все заказы пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
