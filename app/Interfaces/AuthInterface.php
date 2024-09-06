<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthInterface
{
    public function register(array $data);
    public function login(array $data): string|bool;
    public function profile(): ?User;
    public function refreshToken(): string;
    public function logout(): void;
}
