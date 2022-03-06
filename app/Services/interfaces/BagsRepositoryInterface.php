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
     * @param int $pageSize количество элементов на странице
     * @return mixed
     */
    public function getAllUsingGrid(InputSource $input, int $pageSize = 15);

    /**
     * Метод возвращает экземпляр товара с id = $id,
     * если такой имеется - иначе null
     * @param int $id идентификатор товара в таблице 'bags'
     * @return \App\Models\Bag|Null
     */
    public function getFistOrNull(int $id): Bag|null;

    /**
     * Метод получает все товары из таблицы 'bags' с использыванием пагинации
     *
     * @param int $pageSize количество элементов на страницу
     * @return mixed
     */
    public function getAllWithPag(int $pageSize = 15);

    /**
     * Метод получает все товары, названия которых похожи переданной строке
     * из таблицы 'bags' с использыванием пагинации
     *
     * @param string $search строка, по которой производится поиск
     * @param int $pageSize количество элементов на страницу
     * @return mixed
     */
    public function getAllBySearchWithPag(string $search, int $pageSize = 15);

    /**
     * Метод возвращает экземпляр товара, который соответствует условию $where
     *
     * @param array $where условное выражение в виде массива для метода where()
     * @return Bag|Null
     */
    public function getFirstWhereOrNull(array $where);
}
