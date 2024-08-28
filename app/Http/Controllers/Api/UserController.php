<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * UserController constructor.
     * 
     */
    public function __construct(private UserService $service){}
    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $users = $this->service->getUsers();
            return $users;
            return response()->json([
                "success"=>true,
                "users" => UserResource::collection($users),
                "message" => "Users fetched successfully"
            ], 200);
            // return ResponseHelper::successResponse(["users" => UserResource::collection($users)], "Users fetched successfully", 200);
        } catch (\Exception $e) {
            return response()->json([
                "success"=>false,
                "message" => "Users fetch failed",
                "errors" => $e->getMessage()
            ], $e->getCode() ?? 500);
            // return ResponseHelper::failResponse("Users fetch failed.", [$e->getMessage()], $e->getCode() ?? 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreUserRequest $request
     * 
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->service->createUser($request->validated());
            return response()->json([
                "success"=>true,
                "message" => "User created successfully",
                "user" => UserResource::make($user),
            ], 201);
            // return ResponseHelper::successResponse(["user" => UserResource::make($user)], "User created successfully", 201);
        } catch (\Exception $e) {
            return response()->json([
                "success"=>false,
                "message" => "User creation failed",
                "errors" => $e->getMessage()
            ], $e->getCode() ?? 500);
            // return ResponseHelper::failResponse("User creation failed.", [$e->getMessage()], $e->getCode() ?? 500);
        }
    }

    /**
     * Display the specified resource.
     * @param User $user
     * 
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        try {
            return response()->json([
                "success"=>true,
                "user" => UserResource::make($user),
                "message" => "User fetched successfully"
            ], 200);
            // return ResponseHelper::successResponse(["user" => UserResource::make($user)], "User fetched successfully", 200);
        } catch (\Exception $e) {
            return response()->json([
                "success"=>false,
                "message" => "User fetch failed",
                "errors" => $e->getMessage()
            ], $e->getCode() ?? 500);
            // return ResponseHelper::failResponse("User fetch failed.", [$e->getMessage()], $e->getCode() ?? 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param User $user
     * 
     * @return JsonResponse
     */
    public function update(Request $request, User $user): JsonResponse
    {
        try {
            $user = $this->service->updateUser($user, $request->all());
            return response()->json([
                "success"=>true,
                "user" => UserResource::make($user),
                "message" => "User updated successfully"
            ], 200);
            // return ResponseHelper::successResponse(["user" => UserResource::make($user)], "User updated successfully", 200);
        } catch (\Exception $e) {
            return response()->json([
                "success"=>false,
                "message" => "User update failed",
                "errors" => $e->getMessage()
            ], $e->getCode() ?? 500);
            // return ResponseHelper::failResponse("User update failed.", [$e->getMessage()], $e->getCode() ?? 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     * 
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $this->service->deleteUser($user);
            return response()->json([
                "success"=>true,
                "message" => "User deleted successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success"=>false,
                "message" => "User delete failed",
                "errors" => $e->getMessage()
            ], $e->getCode() ?? 500);
            // return ResponseHelper::failResponse("User delete failed.", [$e->getMessage()], $e->getCode() ?? 500);
        }
        
        
    }
}
