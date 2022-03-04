<?php

namespace App\Services\interfaces;

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
}
