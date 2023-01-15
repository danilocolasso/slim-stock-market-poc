<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\StockMarket;
use App\Services\StooqService;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HelloController
{
    /**
     * HelloController constructor.
     */
    public function __construct()
    {
    }

    public function test(Request $request, Response $response, array $args)
    {
        $params = $request->getQueryParams();
        $service = new StooqService();
        $data = $service->getStockMarketValues($params['q']);

//        var_dump(DB::table('stock_market')->get()); die();
        var_dump(StockMarket::all()->toArray()); die();

        var_dump($data);
        die();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function hello(Request $request, Response $response, array $args): Response
    {
        $name = $args['name'];
        $body = "Hello, $name";

        $response->getBody()->write($body);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function bye(Request $request, Response $response, array $args): Response
    {
        $name = $args['name'];
        $body = "Bye, $name";

        $response->getBody()->write($body);

        return $response;
    }
}
