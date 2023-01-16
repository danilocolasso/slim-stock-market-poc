<?php

namespace App\Services;

use App\Interfaces\MailerInterface;
use Swift_Mailer;

class EmailService implements MailerInterface
{
    public function __construct(
        private Swift_Mailer $mailer
    ) {}

    public function send(string $to, string $subject, string $body): void
    {
        $message = new \Swift_Message($subject);

        $message
            ->setFrom([$_ENV['MAILER_FROM']])
            ->setTo([$to])
            ->setBody($body);

        $this->mailer->send($message);
    }
}