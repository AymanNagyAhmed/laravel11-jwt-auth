<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface
{
    public function getUsers(): array;

    public function createUser(array $data): User;

    // public function getUserById(int $id): array;

    public function updateUser(User $user, array $data): User;

    public function deleteUser(User $user): void;
    
}