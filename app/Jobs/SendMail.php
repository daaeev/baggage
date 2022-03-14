<?php

namespace App\Jobs;

use App\Services\interfaces\MailSenderInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Mailable $mail, protected string $to)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MailSenderInterface $mailer)
    {
        $mailer->send($this->mail, $this->to);
    }
}
