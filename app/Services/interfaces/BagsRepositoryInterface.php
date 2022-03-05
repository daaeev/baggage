<?php

namespace App\Services\interfaces;

use App\Models\Bag;
use ViewComponents\ViewComponents\Input\InputSource;

interface BagsRepositoryInterface
{
    /**
     * Метод возвращает список всех товаров,
     * используя библиотеку для построения таблицы (view-components/grid)
     * @param InputSource $input
     * @return mixed
     */
    public function getAllUsingGrid(InputSource $input);

    /**
     * Метод возвращает экземпляр товара с id = $id,
     * если такой имеется - иначе null
     * @param int $id идентификатор товара в таблице 'bags'
     * @return \App\Models\Bag|Null
     */
    public function getFistOrNull(int $id): Bag|null;
}
