<?php

namespace App\Actions\RolePermission;

use App\Models\Role;

class CreateRolePermission
{
    public function execute(Role $role, array $permissionId): Role
    {
        $role->permissions()->attach([$permissionId]);
        return $role->load('permissions');
    }
}
