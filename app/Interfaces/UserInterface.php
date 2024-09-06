<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserInterface
{
    public function getUsers(int $perPage): LengthAwarePaginator;

    public function createUser(array $data): ?User;

    public function getUserById(int $id): ?User;

    public function updateUser(int $id, array $data): ?User;

    public function deleteUser(int $id): void;

    public function getUserByEmail(string $email): ?User;
}
