<?php

namespace App\Interfaces;

interface MailerInterface
{
    public function send(string $to, string $subject, string $body): void;
}