<?php

namespace Tests\Services;

use App\Services\AbstractStockMarket;
use App\Services\EmailService;
use App\Services\StooqService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class StooqServiceTest extends TestCase
{
    private const HTTP_OK = 200;

    private StooqService $stooqService;
    private ClientInterface $client;
    private EmailService|MockObject $mailer;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(Client::class);
        $this->mailer = $this->createMock(EmailService::class);

        $this->stooqService = new StooqService($this->client, $this->mailer);
    }

    /** @dataProvider csvDataProvider */
    public function testGetDataShouldReturnArray(string $csv, array $expected): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')
            ->willReturn($csv);

        $this->client
            ->method('request')
            ->willReturn(new Response(self::HTTP_OK, [], $csv));

        $result = $this->stooqService->getData('abc');

        $this->assertEquals($expected, $result);
        $this->assertMailSent($expected);
    }
    public function csvDataProvider(): \Generator
    {
        yield [
            'csv' =>  'Symbol,Date,Time,Open,High,Low,Close,Volume,Name' . PHP_EOL
                . 'EUR,2023-02-13,17:03:49,15,15.08,14.65,14.89,82437,EUROCASH',
            'expected' => [
                'symbol' => 'EUR',
                'date' => '2023-02-13',
                'time' => '17:03:49',
                'open' => '15',
                'high' => '15.08',
                'low' => '14.65',
                'close' => '14.89',
                'volume' => '82437',
                'name' => 'EUROCASH',
            ],
        ];
    }
    private function assertMailSent(array $body): void
    {
        $this->mailer
            ->expects($this->once())
            ->method('send')
            ->with('test@example.com', AbstractStockMarket::EMAIL_SUBJECT, json_encode($body));

        $this->assertTrue($this->stooqService->sendEmail);
        $this->stooqService->sendByEmail('test@example.com');
    }
}
