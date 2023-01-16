<?php

namespace App\Interfaces;

use Psr\Http\Client\ClientInterface;

interface StockMarketInterface
{
    public function __construct(ClientInterface $client, MailerInterface $mailer);
    public function getData(string $stockCode): array;
    public function sendByEmail(string $email): void;
}