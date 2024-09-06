<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     *
     * @param AuthService $service The instance of the AuthService class.
     */
    public function __construct(private AuthService $service) {}

    /**
     * Register a new user.
     *
     * @param StoreUserRequest $request The request object containing the user data.
     * @return JsonResponse The JSON response containing the result of the registration.
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->service->register($request->validated());
            return response()->json([
                "success" => true,
                "message" => "User created successfully",
                "data" => ["user" => UserResource::make($user)],
            ], 201);
            // return ResponseHelper::successResponse(["user" => UserResource::make($user)], "User created successfully", 201);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "User creation failed",
                "errors" => $e->getMessage()
            ], $e->getCode() ?? 500);
            // return ResponseHelper::failResponse("User creation failed.", [$e->getMessage()], $e->getCode() ?? 500);
        }
    }

    /**
     * Logs in a user.
     *
     * @param LoginRequest $request The login request.
     *
     * @return JsonResponse The JSON response containing the login result.
     *
     * @throws \Exception If an error occurs during the login process.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->service->login($request->all());
            if (empty($result)) {
                return response()->json([
                    "success" => false,
                    "message" => "User login failed",
                    "errors" => "Invalid credentials"
                ], 401);
                // return ResponseHelper::failResponse("User login failed.", ["Invalid credentials"], 401);
            }
            return response()->json([
                "success" => true,
                "message" => "User logged in successfully",
                "data" => [
                    "user" => UserResource::make($result['user']),
                    "access_token" => [
                        "token_type" => "bearer",
                        "expiries_in" => JWTAuth::factory()->getTTL() * 60,
                        "token" => $result['token'],
                    ],
                ],
            ], 200);
            // return ResponseHelper::successResponse(["auth" => $auth], "User logged in successfully", 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "User login failed",
                "errors" => $e->getMessage()
            ], $e->getCode() ?? 500);
            // return ResponseHelper::failResponse("User login failed.", [$e->getMessage()], $e->getCode() ?? 500);
        }
    }

    /**
     * Retrieves the user profile.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the user profile.
     */
    public function profile(): JsonResponse
    {
        try {
            $auth = $this->service->profile();
            return response()->json([
                "success" => true,
                "message" => "User profile retrieved successfully",
                "data" => ["user" => UserResource::make($auth)],
            ], 200);
            // return ResponseHelper::successResponse(["auth" => $auth], "User profile retrieved successfully", 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "User profile retrieval failed",
                "errors" => $e->getMessage()
            ], $e->getCode() ?? 500);
            // return ResponseHelper::failResponse("User profile retrieval failed.", [$e->getMessage()], $e->getCode() ?? 500);
        }
    }

    public function refreshToken(): JsonResponse
    {
        try {
            $newToken = $this->service->refreshToken();
            return response()->json([
                "success" => true,
                "message" => "Token refreshed successfully",
                "data" => [
                    "access_token" => [
                        "token_type" => "Bearer",
                        "expiries_in" => JWTAuth::factory()->getTTL() * 60,
                        "token" => $newToken,
                    ]
                ],
            ], 200);
            // return ResponseHelper::successResponse(["token" => $newToken], "Token refreshed successfully", 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Token refresh failed",
                "errors" => $e->getMessage()
            ], $e->getCode() ?? 500);
            // return ResponseHelper::failResponse("Token refresh failed.", [$e->getMessage()], $e->getCode() ?? 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->service->logout();
            return response()->json([
                "success" => true,
                "message" => "User logged out successfully",
            ], 200);
            // return ResponseHelper::successResponse([], "User logged out successfully", 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "User logout failed",
                "errors" => $e->getMessage()
            ], $e->getCode() ?? 500);
            // return ResponseHelper::failResponse("User logout failed.", [$e->getMessage()], $e->getCode() ?? 500);
        }
    }
}
