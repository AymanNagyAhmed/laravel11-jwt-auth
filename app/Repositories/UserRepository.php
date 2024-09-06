<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserInterface
{
    /**
     * Retrieve all users from the database.
     *
     * @return array
     */
    public function getUsers(int $perPage = 10): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }

    /**
     * Retrieve a user by their ID.
     *
     * @param int $id The ID of the user.
     * @return User|null The user object if found, null otherwise.
     */
    public function getUserById(int $id): ?User
    {
        return User::find($id);
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

    /**
     * Update a user.
     *
     * @param User $id The user ID.
     * @param array $data The data to update the user with.
     * @return User The updated user.
     */
    public function updateUser(int $id, array $data): User
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
    public function deleteUser(int $id): void
    {
        User::findOrFail($id)->delete();
    }

    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
