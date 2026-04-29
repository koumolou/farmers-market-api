<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Responses\ApiResponse;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // Admin sees all supervisors
            $users = $this->userService->getSupervisors();
        } else {
            // Supervisor sees only their own operators
            $users = $this->userService->getOperatorsBySupervisor($user->id);
        }

        return ApiResponse::success($users);
    }

    public function store(StoreUserRequest $request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $created = $this->userService->createSupervisor($request->validated());
            $message = 'Supervisor created successfully';
        } else {
            $created = $this->userService->createOperator($request->validated());
            $message = 'Operator created successfully';
        }

        return ApiResponse::success($created, $message, 201);
    }

    public function show(int $id)
    {
        $user = $this->userService->findById($id);
        return ApiResponse::success($user);
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->userService->update($id, $request->validated());
        return ApiResponse::success($user, 'User updated successfully');
    }

    public function destroy(int $id)
    {
        // Prevent self-deletion
        if (auth()->id() === $id) {
            return ApiResponse::error('You cannot delete your own account', 403);
        }

        $this->userService->delete($id);
        return ApiResponse::success(null, 'User deleted successfully');
    }
}