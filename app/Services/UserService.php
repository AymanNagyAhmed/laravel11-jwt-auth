<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Models\User;

/**
 * UserService class.
 *
 * This class is responsible for handling user-related operations.
 */
class UserService
{
    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository The user repository.
     */
    public function __construct(private UserRepository $userRepository) {}

    /**
     * Retrieves an array of users.
     *
     * @return 
     */
    public function getUsers(int $perPage = 10)
    {
        $users = $this->userRepository->getUsers($perPage);
        return UserResource::collection($users);
    }

    /**
     * Create a new user.
     *
     * @param array $data The data for creating the user.
     * @return User The created user.
     */
    public function createUser(array $data): User
    {
        return $this->userRepository->createUser($data);
    }

    /**
     * Retrieves a user by their ID.
     *
     * @param User $user The user object.
     * @return array The user data as an array.
     */
    public function getUserById(int $id): User
    {
        return $this->userRepository->getUserById($id);
    }

    /**
     * Update a user.
     *
     * @param User $user The user to update.
     * @param array $data The data to update the user with.
     * @return User The updated user.
     */
    public function updateUser(int $id, array $data): User
    {
        return $this->userRepository->updateUser($id, $data);
    }

    /**
     * Deletes a user.
     *
     * @param User $user The user to be deleted.
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $this->userRepository->deleteUser($id);
    }
}
