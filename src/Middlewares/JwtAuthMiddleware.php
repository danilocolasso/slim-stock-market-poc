<?php

namespace App\Middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JwtAuthMiddleware implements MiddlewareInterface
{
    public const JWT_ALG = 'HS256';

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $headers = $request->getHeaders();

        if (!isset($headers['Authorization'])) {
            throw new \Exception('JWT Token not found.');
        }

        try {
            $token = trim(str_replace('Bearer', '', $headers['Authorization'][0]));
            JWT::decode($token, new Key($_ENV['APP_KEY'], self::JWT_ALG));
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $handler->handle($request);
    }
}