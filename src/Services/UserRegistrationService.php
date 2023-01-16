<?php

namespace App\Services;

use App\Models\User;
use Exception;

class UserRegistrationService
{
    /**
     * @throws Exception
     */
    public function register(array $data): void
    {
        $exists = User::where('username', $data['username'])->exists();

        if ($exists) {
            throw new Exception('Username already exists.');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_ARGON2ID);
        User::create($data);
    }
}