<?php

namespace App\Services\interfaces;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

interface UserRepositoryInterface
{
    /**
     * Метод возвращает экземпляр аутентифицированного пользователя
     * @return mixed
     */
    public function getAuthenticated();

    /**
     * Метод возвращает экземпляр пользователя с id = $id,
     * если такой имеется - иначе null
     * @return \App\Models\User|Null
     */
    public function getFistOrNull(int $id): User|null;
}
