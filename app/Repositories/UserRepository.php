<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    /**
     * Retrieve all users from the database.
     *
     * @return array
     */
    public function getUsers(): array
    {
        return User::all()->toArray();
    }

    /**
     * Create a new user.
     *
     * @param array $data The data for creating the user.
     * @return User The created user.
     */
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    // public function getUserById(User $user): array
    // {
    //     return User::findOrFail($id)->toArray();
    // }

    /**
     * Update a user.
     *
     * @param User $id The user ID.
     * @param array $data The data to update the user with.
     * @return User The updated user.
     */
    public function updateUser(User $id, array $data): User
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    /**
     * Delete a user.
     *
     * @param User $use The user to be deleted.
     * @return void
     */
    public function deleteUser(User $use): void
    {
        $user->delete();
    }
}
