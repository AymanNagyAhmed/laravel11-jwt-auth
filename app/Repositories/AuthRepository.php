<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository implements AuthInterface
{
    /**
     * Register a new user.
     *
     * @param array $data The user data.
     * @return User The newly created user.
     */
    public function register(array $data): User
    {
        return User::create($data);
    }

    /**
     * Logs in a user.
     *
     * @param array $data The user login data.
     * @return string|bool Returns the JWT token if the login is successful, otherwise returns false.
     */
    public function login(array $data): string|bool
    {
        return JWTAuth::attempt([
            "email" => $data['email'],
            "password" => $data['password'],
        ]);
    }

    /**
     * Retrieve the authenticated user's profile.
     *
     * @return User|null The authenticated user's profile, or null if not authenticated.
     */
    public function profile(): ?User
    {
        return JWTAuth::user();
    }

    public function refreshToken(): string
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());
        JWTAuth::invalidate(JWTAuth::getToken());
        return $token;
    }

    public function logout(): void
    {
        JWTAuth::parseToken()->invalidate();
    }
}
