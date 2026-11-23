<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Services\Admin\RoleService;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Exception;

class RoleController extends Controller
{
    public function __construct(protected RoleService $roleService) {}

    public function index(): JsonResponse
    {
        $roles = $this->roleService->getRoles();

        return response()->json($roles);
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            $role = $this->roleService->createRole($request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => 'Role created successfully.',
                'data'    => $role,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to create role.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Role $role)
    {
        try {
            $this->roleService->deleteRole($role);

            return response()->json([
                'status'  => 'success',
                'message' => 'Role deleted successfully.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to delete role: ' . $e->getMessage()
            ], 500);
        }
    }
}
