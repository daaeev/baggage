<?php

namespace App\Services\interfaces;

use Illuminate\Support\Facades\Auth;

interface UserRepositoryInterface
{
    /**
     * Метод возвращает экземпляр аутентифицированного пользователя
     * @return mixed
     */
    public function getAuthenticated();
}
