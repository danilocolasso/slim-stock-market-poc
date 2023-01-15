<?php

namespace App\Services;

use App\Interfaces\StockMarketInterface;
use Psr\Http\Client\ClientInterface;

class StooqService implements StockMarketInterface
{
    private const BASE_URI = 'https://stooq.com';
    private const ENDPOINT = '/q/l/';

    public function __construct(
        protected ClientInterface $client
    ) {}

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

        return $this->csvToArray($contents);
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

            $data[] = array_combine($headers, $row);
        }

        return $data;
    }
}