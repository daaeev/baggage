<?php

namespace App\Services;

use App\Jobs\SendMail;
use App\Services\interfaces\MailSenderInterface;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class MailSender implements MailSenderInterface
{
    /**
     * @inheritDoc
     */
    public function send(Mailable $mail, string $to)
    {
        Mail::to($to)->send($mail);
    }

    /**
     * @inheritDoc
     */
    public function queue(Mailable $mail, string $to)
    {
        SendMail::dispatch($mail, $to);
    }
}
