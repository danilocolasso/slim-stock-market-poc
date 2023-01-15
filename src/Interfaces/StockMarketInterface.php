<?php

namespace App\Interfaces;

use Psr\Http\Client\ClientInterface;

interface StockMarketInterface
{
    public function __construct(ClientInterface $client);
    public function getData(string $stockCode): array;
}