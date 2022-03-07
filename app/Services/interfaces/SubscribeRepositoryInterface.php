<?php

namespace App\Services\interfaces;

interface SubscribeRepositoryInterface
{
    /**
     * Метод проверяет наличие подписки пользователя с id = $user_id
     * на товар с id = $bag_id
     *
     * @param int $user_id идентификатор пользователя
     * @param int $bag_id идентификатор товара
     * @return mixed
     */
    public function userIsSubscribed(int $user_id, int $bag_id);

    /**
     * Метод возвращает все подписки, связанные с товаром id = $bag_id
     *
     * @param int $bag_id
     * @return mixed
     */
    public function getAllSubscriptionsByBag(int $bag_id);
}
