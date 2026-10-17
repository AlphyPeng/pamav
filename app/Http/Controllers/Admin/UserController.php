<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->integer('per_page', 10);

        $filters = $request->only(['search', 'status']);

        $users = $this->userService->getPaginatedUsers($filters, $perPage);

        return response()->json($users);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => 'User created successfully.'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to create user.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
