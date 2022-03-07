<?php

namespace App\Services\interfaces;

use App\Models\Order;
use ViewComponents\ViewComponents\Input\InputSource;

interface OrdersRepositoryInterface
{
    /**
     * Метод возвращает список всех заказов,
     * используя библиотеку для построения таблицы (view-components/grid)
     *
     * @param InputSource $input
     * @param int $pageSize количество элементов на странице
     * @return mixed
     */
    public function getAllUsingGrid(InputSource $input, int $pageSize = 15);

    /**
     * Метод возвращает экземпляр заказа с id = $id,
     * если такой имеется - иначе null
     * @return \App\Models\Order|Null
     */
    public function getFistOrNull(int $id): Order|null;
}
