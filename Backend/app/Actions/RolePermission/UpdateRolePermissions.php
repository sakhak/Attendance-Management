<?php

namespace App\Actions\RolePermission;

use App\Models\Role;

class UpdateRolePermissions
{
    public function execute(Role $role, array $permissionIds): Role
    {
        $role->permissions()->sync($permissionIds);
        return $role->load('permissions');
    }
}
