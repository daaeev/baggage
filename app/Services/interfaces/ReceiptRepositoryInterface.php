<?php

namespace App\Services\interfaces;

use ViewComponents\ViewComponents\Input\InputSource;

interface ReceiptRepositoryInterface
{
    /**
     * Метод возвращает список всех чеков,
     * используя библиотеку для построения таблицы (view-components/grid)
     *
     * @param InputSource $input
     * @param int $pageSize количество элементов на странице
     * @return mixed
     */
    public function getAllUsingGrid(InputSource $input, int $pageSize = 15);
}
