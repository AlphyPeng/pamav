<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePermissionRequest;
use App\Services\Admin\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class PermissionController extends Controller
{
    public function __construct(protected PermissionService $permissionService) {}

    public function index(): JsonResponse
    {
        $permissions = $this->permissionService->getPaginatedPermissions();

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
}
