<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePermissionRequest;
use App\Services\Admin\PermissionService;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;
use Exception;

class PermissionController extends Controller
{
    public function __construct(protected PermissionService $permissionService) {}

    public function index(): JsonResponse
    {
        $permissions = $this->permissionService->getPermissions();

        return response()->json($permissions);
    }

    public function store(StorePermissionRequest $request)
    {
        try {
            $permission = $this->permissionService->createPermission($request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => 'Permission created successfully.',
                'data'    => $permission,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to create permission.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            $this->permissionService->deletePermission($permission);

            return response()->json([
                'status'  => 'success',
                'message' => 'Permission deleted successfully.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to delete permission: ' . $e->getMessage()
            ], 500);
        }
    }
}
