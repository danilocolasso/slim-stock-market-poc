<?php

namespace App\Middlewares;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class JwtAuthMiddleware implements MiddlewareInterface
{
    public const JWT_ALG = 'HS256';

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $headers = $request->getHeaders();

            if (!isset($headers['Authorization'])) {
                throw new \Exception('JWT Token not found.');
            }

            $token = trim(str_replace('Bearer', '', $headers['Authorization'][0]));
            $user = JWT::decode($token, new Key($_ENV['APP_KEY'], self::JWT_ALG));

            if (!User::where('username', $user->username)->exists()) {
                throw new \Exception('The given user doesn\'t exist.');
            }

            $request = $request->withAttribute('user', $user);

        } catch (\Exception $exception) {
            throw new HttpUnauthorizedException($request, $exception->getMessage());
        }

        return $handler->handle($request);
    }
}