<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Support\Str;

use App\Permission;

class RolesController extends Controller
{
    public function getRoles(Request $request)
    {
        $query = $request->query('query') !== null ? $request->query('query') : "";
        $roles = new Role();

        $roles = $roles->with('permissions', 'users')->where('name', 'like', '%' . $query . '%')->orWhere('display_name', 'like', '%' . $query . '%')->paginate(15);

        return response()->json(compact('roles'));
    }

    public function saveRole(Request $request)
    {
        $permissions = $request['permissions'];
        $name = strtolower($request['name']);
        $description = $request['description'];
        $display_name = strtolower($request['name']);


        $role = Role::create([
            'name' => $name,
            'display_name' => $display_name,
            'description' => $description
        ]);


        if ($permissions !== null) {
            $role->attachPermissions($permissions);
        }



        return response()->json(['message' => "Saved Role Successfully"]);
    }
    public function showRole($role)
    {
        $role_id = $role;
        $role = new Role();
        $roles = null;

        if ($role->where('id', $role_id)->exists()) {
            $roles = $role->with('permissions', 'users')->find($role_id);

            return response()->json(compact('roles'));
        } else {
            $roles = 'role not found';
        }
        return response()->json(compact('roles'));
    }

    public function getPermissions(Request $request)
    {
        $query = $request->query('query') !== null ? $request->query('query') : "";
        $permissions = new Permission();

        $permissions = $permissions->where('name', 'like', '%' . $query . '%')->orWhere('display_name', 'like', '%' . $query . '%')->get()->groupBy(function ($queryGroup) {
            return Str::singular(Str::after($queryGroup->name, "_"));
        });

        return response()->json(compact('permissions'));
    }

    public function showPermission($permission)
    {
    }
}
