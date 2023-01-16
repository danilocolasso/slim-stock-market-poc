<?php

namespace App\Services;

use App\Interfaces\MailerInterface;
use App\Interfaces\StockMarketInterface;
use App\Models\StockMarket;
use Psr\Http\Client\ClientInterface;

abstract class AbstractStockMarket implements StockMarketInterface
{
    public bool $sendEmail = true;
    protected array $data = [];

    protected const EMAIL_SUBJECT = 'Stock Market Right Now';

    public function __construct(
        protected ClientInterface $client,
        protected MailerInterface $mailer
    ) {}

    public function sendByEmail(string $email): void
    {
        if ($this->sendEmail && $this->data) {
            $this->mailer->send($email, self::EMAIL_SUBJECT, json_encode($this->data));
        }
    }
}