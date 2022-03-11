<?php

namespace App\Services\interfaces;

use Illuminate\Contracts\Mail\Mailable;

interface MailSenderInterface
{
    /**
     * Отправка почты $mail на электронный адрес $to
     *
     * Синхронная отправка почты. Пользователь должен
     * дождаться полной отправки перед получением HTTP-ответа.
     *
     * @param Mailable $mail экземпляр почты
     * @param string $to электронный адрес
     * @return void
     */
    public function send(Mailable $mail, string $to);

    /**
     * Отправка почты $mail на электронный адрес $to
     *
     * Асинхронная отправка почты. Используется механизм очередей
     *
     * @param Mailable $mail экземпляр почты
     * @param string $to электронный адрес
     * @return void
     */
    public function queue(Mailable $mail, string $to);
}
