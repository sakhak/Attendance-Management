<?php

namespace App\Actions\RolePermission;

use App\Models\Role;

class DeleteRolePermission
{
    public function execute(Role $role, array $permissionId): Role
    {
        $role->permissions()->detach($permissionId);
        return $role->load('permissions');
    }
}
