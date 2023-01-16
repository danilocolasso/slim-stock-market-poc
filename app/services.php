<?php
declare(strict_types=1);

use App\Interfaces\MailerInterface;
use App\Interfaces\StockMarketInterface;
use App\Services\EmailService;
use App\Services\StooqService;
use DI\ContainerBuilder;
use GuzzleHttp\Client;
use Illuminate\Database\Capsule\Manager as Capsule;

return function (ContainerBuilder $containerBuilder) {

    $capsule = new Capsule();
    $capsule->addConnection([
        'driver' => $_ENV['DB_CONNECTION'],
        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_DATABASE'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'port' => $_ENV['DB_PORT'],
        'charset' => $_ENV['DB_CHARSET'],
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    $containerBuilder->addDefinitions([
        Swift_Mailer::class => function() {
            $host = $_ENV['MAILER_HOST'] ?? 'smtp.mailtrap.io';
            $port = intval($_ENV['MAILER_PORT']) ?? 465;
            $username = $_ENV['MAILER_USERNAME'] ?? 'test';
            $password = $_ENV['MAILER_PASSWORD'] ?? 'test';

            $transport = (new Swift_SmtpTransport($host, $port))
                ->setUsername($username)
                ->setPassword($password)
            ;

            return new Swift_Mailer($transport);
        },

        Client::class => fn() => new Client(),
        MailerInterface::class => fn(Swift_Mailer $mailer) => new EmailService($mailer),
        StockMarketInterface::class => fn(Client $client, EmailService $mailer) => new StooqService($client, $mailer),
    ]);
};
