<?php

namespace App\Repositories;
use App\Models\StockMarket;

class StockMarketRepository
{
    public static function saveHistory(array $data): void
    {
        if (!$data) {
            return;
        }

        StockMarket::updateOrCreate(
            ['name' => $data['name']],
            $data
        );
    }

    public static function getHistory(): array
    {
        return StockMarket::all()->toArray();
    }
}