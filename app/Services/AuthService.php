<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use App\Models\Auth;
use App\Models\User;
use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * AuthService class.
 *
 * This class is responsible for handling auth-related operations.
 */
class AuthService
{
    /**
     * AuthService constructor.
     *
     * @param AuthRepository $authRepository The auth repository.
     */
    public function __construct(private AuthRepository $authRepository, private UserRepository $userRepository) {}

    /**
     * Retrieves an array of auths.
     *
     * @return 
     */
    public function register(array $data): User
    {
        return $this->authRepository->register($data);
    }

    /**
     * Logs in a user.
     *
     * @param array $data The login data.
     * @return array The token and user information if login is successful, otherwise an empty array.
     */
    public function login(array $data): array
    {
        $token = $this->authRepository->login($data);
        if ($token) {
            $user = $this->userRepository->getUserByEmail($data['email']);
            return [
                'token' => $token,
                'user' => $user
            ];
        }
        return [];
    }

    /**
     * Retrieve the user profile.
     *
     * @return User|null The user profile or null if not found.
     */
    public function profile(): ?User
    {
        return $this->authRepository->profile();
    }

    public function refreshToken(): string
    {

        return $this->authRepository->refreshToken();
    }

    public function logout(): void
    {
        $this->authRepository->logout();
    }
}
