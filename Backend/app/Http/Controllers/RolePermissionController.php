<?php

namespace App\Http\Controllers;

use App\Actions\RolePermission\CreateRolePermission;
use App\Actions\RolePermission\UpdateRolePermissions;
use App\Actions\RolePermission\DeleteRolePermission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RolePermissionController extends Controller
{
    // CREATE (attach one permission)
    public function store(Request $request, Role $role)
    {
        try {
            $validated = $request->validate([
                'permission_id' => ['required', 'array'],
                'permission_id.*' => ['integer', 'exists:permissions,id'],
            ]);

            $action = new CreateRolePermission();
            $role = $action->execute($role, $validated['permission_id']);

            return response()->json([
                'data' => $role,
                'message' => 'Permission attached to role successfully',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error attaching permission',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // UPDATE (sync/replace all permissions)
    public function update(Request $request, Role $role)
    {
        try {
            $validated = $request->validate([
                'permission_ids' => ['required', 'array'],
                'permission_ids.*' => ['integer', 'exists:permissions,id'],
            ]);

            $action = new UpdateRolePermissions();
            $role = $action->execute($role, $validated['permission_ids']);

            return response()->json([
                'data' => $role,
                'message' => 'Role permissions updated successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating role permissions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // DELETE (detach one permission)
    public function destroy(Role $role, array $permissionId)
    {
        try {
            $action = new DeleteRolePermission();
            $role = $action->execute($role, $permissionId);

            return response()->json([
                'data' => $role,
                'message' => 'Permission detached from role successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error detaching permission',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
