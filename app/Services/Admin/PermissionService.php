<?php

namespace App\Services\Admin;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    public function getPaginatedPermissions()
    {
        return Permission::all();
    }

    public function createPermission(array $data): Permission
    {
        return DB::transaction(function () use ($data) {
            $permission = Permission::create([
                'name'       => $data['name'],
                'guard_name' => $data['guard_name'] ?? 'web',
            ]);

            // Clear the Spatie permission cache
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $permission;
        });
    }
}
