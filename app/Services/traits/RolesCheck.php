<?php

namespace App\Services\traits;

/**
 * Трейт с методами для проверки прав пользователя
 */
trait RolesCheck
{
    /**
     * @return bool результат проверки
     */
    public function isAdmin(): bool
    {
        if ($this->getStatus() == $this::STATUS_ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * Метод возвращает статус пользователя в виде числа
     * @return int
     */
    protected abstract function getStatus(): int;
}
