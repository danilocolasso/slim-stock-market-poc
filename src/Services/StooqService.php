<?php

namespace App\Services;

use App\Repositories\StockMarketRepository;

class StooqService extends AbstractStockMarket
{
    private const BASE_URI = 'https://stooq.com';
    private const ENDPOINT = '/q/l/';

    public function getData(string $stockCode): array
    {
        $requestOptions = [
            'base_uri' => self::BASE_URI,
            'query' => [
                's' => $stockCode,
                'f' => 'sd2t2ohlcvn',
                'h' => '',
                'e' => 'csv',
            ],
        ];

        $res = $this->client->request('GET', self::ENDPOINT, $requestOptions);
        $contents = $res->getBody()->getContents();
        $this->data = $this->csvToArray($contents);

        StockMarketRepository::saveHistory($this->data);

        return $this->data;
    }

    private function csvToArray(string $csvString): array
    {
        $rows = explode(PHP_EOL, $csvString);
        $headers = str_getcsv(strtolower($rows[0]));
        unset($rows[0]);

        $data = [];
        foreach ($rows as $row) {
            $row = str_getcsv($row);
            if (count($row) != count($headers)) {
                continue;
            }

            $data = array_combine($headers, $row);
        }

        return $data;
    }
}