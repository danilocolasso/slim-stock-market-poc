<?php

namespace App\Services;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;

class UserLoginService
{
    private const TOKEN_ALG = 'HS256';

    /**
     * @throws Exception
     */
    public function login(string $username, string $password): array
    {
        /** @var User $user */
        $user = User::where('username', $username)->first();

        if (!$user || !password_verify($password, $user->password)) {
            throw new Exception('Username and password do not match.');
        }

        $expirationDate = new \DateTime();
        $expirationDate->modify('+1 day');
        $expirationTimestamp = $expirationDate->getTimestamp();

        $payload = [
            'sub' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'exp' => $expirationTimestamp,
        ];

        $jwt = JWT::encode(
            $payload,
            $_ENV['APP_KEY'],
            self::TOKEN_ALG
        );

        $_SESSION['user'] = $user->toArray();

        return [
            'token' => $jwt,
        ];
    }
}