<?php

namespace App\Controllers;
use App\Services\UserLoginService;
use App\Services\UserRegistrationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    public function register(Request $request, Response $response): ResponseInterface
    {
        try {
            $data = $request->getParsedBody();

            if (
                !isset($data['name']) ||
                !isset($data['email']) ||
                !isset($data['username']) ||
                !isset($data['password'])
            ) {
                throw new \Exception('The fields name, email, username and password are required.');
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('The e-mail is not valid.');
            }

            $service = new UserRegistrationService();
            $service->register($data);

            $response->getBody()->write(json_encode([
                'status' => true,
                'message' => 'User create successfully.'
            ]));
        } catch (\Exception $exception) {
            $response->getBody()->write(json_encode([
                'status' => false,
                'message' => $exception->getMessage(),
            ]));
        }

        return $response;
    }

    public function login(Request $request, Response $response): ResponseInterface
    {
        try {
            $data = $request->getParsedBody();

            if (!isset($data['username']) || !isset($data['password'])) {
                throw new \Exception('The fields Username and Password are required.');
            }

            $service = new UserLoginService();
            $data = $service->login($data['username'], $data['password']);

            $response->getBody()->write(json_encode([
                'status' => true,
                'message' => 'Logged in successfully.',
                'data' => $data,
            ]));
        } catch (\Exception $exception) {
            $response->getBody()->write(json_encode([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => [],
            ]));
        }

        return $response;
    }
}