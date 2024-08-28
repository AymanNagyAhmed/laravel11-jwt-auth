<?php

namespace App\Services;
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
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * Retrieves an array of users.
     *
     * @return array The array of users.
     */
    public function getUsers(): array
    {
        return $this->userRepository->getUsers();
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
    public function getUserById(User $user): array
    {
        return $this->userRepository->getUserById($User);
    }

    /**
     * Update a user.
     *
     * @param User $user The user to update.
     * @param array $data The data to update the user with.
     * @return User The updated user.
     */
    public function updateUser(User $user, array $data): User
    {
        return $this->userRepository->updateUser($user, $data);
    }

    /**
     * Deletes a user.
     *
     * @param User $user The user to be deleted.
     * @return void
     */
    public function deleteUser(User $user): void
    {
        $this->userRepository->deleteUser($user);
    }
}