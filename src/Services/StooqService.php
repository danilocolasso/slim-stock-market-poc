<?php

namespace App\Services;

use GuzzleHttp\Client;
class StooqService
{
    private const URL = 'https://stooq.com/q/l/?s=%s&f=sd2t2ohlcvn&h&e=csv';
    public function getStockMarketValues(string $stockCode): array
    {
        $client = new Client();
        $res = $client->request('GET', sprintf(self::URL, $stockCode));
        $contents = $res->getBody()->getContents();

        $rows = explode(PHP_EOL, $contents);
        $headers = str_getcsv(strtolower($rows[0]));
        unset($rows[0]);

        $data = [];
        foreach ($rows as $row) {
            $row = str_getcsv($row);
            if (count($row) != count($headers)) {
                continue;
            }

            $data[] = array_combine($headers, $row);
        }

        return $data;
    }
}