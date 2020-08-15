<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
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

    public function checkUniqueness(Request $request)
    {
        $email = $request['email'];
        $username = $request['username'];
        $message = [];

        if ($username !== null) {
            $users = new User();
            $x = "";
            do {
                $username .= $x;
                $x++;
            } while ($users->where('username', $username)->exists());
        }
        if ($email !== null) {
            $users = new User();
            $x = "";
            $emailRun = Str::singular(Str::before($email, "@"));
            $emailSuffix = Str::singular(Str::after($email, "@"));
            do {
                $emailRun .= $x;
                $email = $emailRun . '@' . $emailSuffix;

                $x++;
            } while ($users->where('email', $email)->exists());
        }

        return response()->json(compact('username', 'email'));
    }

    public function createUser(Request $request)
    {
        $files = $request['files'];
        $inputs = $request->all();

        $fileNames = null;
        if ($files !== null) {
            $fileNames = [];
            $path = 'images';
            foreach ($files as $key => $file) {
                $file_input = $request->file('file' . $key);
                $filename = strtolower(Str::random(5)) . time() . '_member.'
                    . $file_input->getClientOriginalExtension();

                if (Storage::disk('uploads')->put($path . '/' . $filename,  File::get($file_input))) {
                    array_push($fileNames, $filename);
                }
            }
            $fileNames = $fileNames[0];
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'given_name' => $request->given_name,
            'username' => $request->username,
            'email' => $request->email,
            'slug' => str_slug($request->username),
            'contact' => $request->contact,
            'password' => $request->password,
            'image' => $fileNames,
        ]);

        $user->attachRoles($request['roles'] !== null ? $request['roles'] : []);
        $user->attachPermissions($request['permissions'] !== null ? $request['permissions'] : []);

        return response()->json(['message' => 'saved successfully']);
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
}
