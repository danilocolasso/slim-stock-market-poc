<?php

namespace App\Controllers;

use App\Interfaces\StockMarketInterface;
use App\Repositories\StockMarketRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StockMarketController
{
    public function __construct(
        private StockMarketInterface $stockMarket
    ) {}

    public function getData(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();

        if (!isset($params['q'])) {
            $response->getBody()->write(json_encode([
                'error' => 'The parameter "q" is required.'
            ]));

            return $response;
        }

        $data = $this->stockMarket->getData($params['q']);
        $this->stockMarket->sendByEmail($request->getAttribute('user')->email);

        $response->getBody()->write(json_encode($data));

        return $response;
    }

    public function getHistory(Request $request, Response $response): Response
    {
        $data = StockMarketRepository::getHistory();
        $response->getBody()->write(json_encode($data));

        return $response;
    }
}