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
        } catch (Exception $e) {
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
