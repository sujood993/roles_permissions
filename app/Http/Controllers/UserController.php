<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UserResource::collection(User::all());
        return response()->json([
            "success" => true,
            "message" => "User List",
            "data" => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => ['required', 'email', 'unique:users'],
            'name' => ['required', 'string'],
            'phone' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:6']
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
         $user = new User([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $user->save();
        return response()->json([
            "success" => true,
            "message" => "user has been created",

        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function show($user)
    {
        $user = User::find($user);
        if (!empty($user)) {
            $user = new UserResource($user);
            return response()->json(["success" => true, "data" => $user], 200);
        } else {
            return response()->json(["message" => 'user not found'], 404);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = validator::make($request->all(), [
            'email' => ['required', 'email', 'unique:users'],
            'name' => ['required', 'string'],
            'phone' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:6']
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            "success" => true,
            "message" => "user has been updated",

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return response()->json([
            "success" => true,
            "message" => "user deleted successfully.",

        ], 204);
    }

    protected function assignRule(Request $request, $user)
    {
        $roleIds = $request->role_ids;
        $user = User::find($user);
        if (!empty($roleIds)) {
            foreach ($roleIds as $roleId) {
                $role = Role::find($roleId);
                if (!empty($role)) {
                    if (!$user->roles->contains($roleId)) {
                        $user->roles()->attach($roleId);
                    }
                }
            }
            return response()->json([
                "success" => true,
                "message" => "added new roles successfully.",

            ], 200);
        }
        return response()->json([
            "success" => true,
            "message" => "The role Ids field is empty ",

        ], 200);

    }

    protected function assignPermissionRule(Request $request, $roleId)
    {
        $permissionIds = $request->permission_ids;
        $role = Role::find($roleId);
        if (!empty($permissionIds)) {
            foreach ($permissionIds as $permissionId) {
                $permission = Permission::find($permissionId);
                if (!empty($permission)) {
                    if (!$role->permissions->contains($permissionId)) {
                        $role->permissions()->attach($permissionId);
                    }
                }
            }
            return response()->json([
                "success" => true,
                "message" => "added new permission successfully.",

            ], 200);
        }
        return response()->json([
            "success" => true,
            "message" => "The permission Ids field is empty ",

        ], 200);

    }


}
