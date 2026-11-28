<?php

namespace App\Services\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function getRoles()
    {
        return Role::all();
    }

    public function createRole(array $data): Role
    {
        return DB::transaction(function () use ($data) {
            $guardName = 'web';

            $role = Role::create([
                'name'       => $data['name'],
                'guard_name' => $guardName,
            ]);

            $permissions = Permission::whereIn('id', $data['permissions'])
                ->where('guard_name', $guardName)
                ->get();

            $role->syncPermissions($permissions);

            return $role;
        });
    }

    public function deleteRole(Role $role): bool
    {
        return DB::transaction(function () use ($role) {
            return $role->delete();
        });
    }
}
