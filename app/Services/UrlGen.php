<?php

namespace App\Services;

/**
 * Хелпер для генерации url-адресов
 */
class UrlGen
{
    /**
     * Генерация url-адреса главной страницы
     * @return string url-адрес
     */
    public static function index()
    {
        return '/';
    }

    /**
     * Генерация url-адреса страницы о компании
     * @return string url-адрес
     */
    public static function about()
    {
        return '/about';
    }

    /**
     * Генерация url-адреса страницы связи
     * @return string url-адрес
     */
    public static function contact()
    {
        return '/contact';
    }

    /**
     * Генерация url-адреса страницы каталога товаров
     * @return string url-адрес
     */
    public static function catalog()
    {
        return '/catalog';
    }

    /**
     * Генерация url-адреса страницы подписки на рассылку
     * @return string url-адрес
     */
    public static function newsletter()
    {
        return '/newsletter';
    }

    /**
     * Генерация url-адреса страницы авторизации
     * @return string url-адрес
     */
    public static function login()
    {
        return '/login';
    }

    /**
     * Генерация url-адреса страницы регистрации
     * @return string url-адрес
     */
    public static function register()
    {
        return '/register';
    }
}
