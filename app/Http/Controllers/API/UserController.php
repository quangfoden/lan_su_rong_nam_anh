<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    protected UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    // all languages
    public function allusers()
    {
        $users = User::with(['roles' => function ($query) {
            $query->where('status', 1);
        }])->get()->toArray();

        $roles = Role::where('status', 1)->get()->toArray();
        $responseData = [
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => ['users' => $users, 'roles' => $roles]
        ];
        return response()->json($responseData);
    }

    // all roles
    public function roles()
    {
        $roles = Role::all()
            ->toArray();
        $responseData = ['status' => 200, 'success' => true, 'message' => 'success', 'data' => $roles];
        return response()->json($responseData);
    }

    //     createNewUser

    public function createNewUser(Request $request)
    {
        $role = Role::where('id', $request->input('role'))->get()->first();
        $oldUser = User::where('email', $request->input('email'))->get()->first();
        if ($oldUser) {
            $responseData = [
                'status' => 200,
                'success' => false,
                'message' => 'This account already exists'
            ];
            return response()->json($responseData);
        }
        if ($role) {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make(""),
                'status' => $request->input('status') ?? 1,
                'is_lock' => $request->input('is_lock') ?? 0,
                'first_login' => 1
            ]);
            $user->assignRole($role->name);
            $user->load([
                'roles' => function ($query) {
                    $query->where('status', 1);
                },
                'roles.permissions' => function ($query) {
                    $query->where('status', 1);
                }
            ]);
            $responseData = [
                'status' => 200,
                'success' => true,
                'message' => 'The user successfully created',
                'data' => ['user_created' => $user]
            ];
            return response()->json($responseData);
        } else {
            $responseData = [
                'status' => 200,
                'success' => false,
                'message' => 'Role not found'
            ];
            return response()->json($responseData);
        }
    }

    // edit 
    public function edit($id)
    {
        $user = User::where('id', $id)->get()->first();
        $user->load('roles');
        $roles = Role::where('status', 1)->get();
        $responseData = [
            'status' => 200,
            'message' => 'success',
            'data' => [
                'user' => $user,
                'roles' => $roles
            ]
        ];
        return response()->json($responseData);
    }

    // update user
    public function changeRoleUser($id, Request $request)
    {
        $user = User::find($id);
        if ($user) {

            $user->load([
                'roles' => function ($query) {
                    $query->where('status', 1);
                }
            ]);
            $roles = Role::where('status', 1)->get();
            foreach ($roles as $role) {
                if ($request->has('role_' . $role->id) && $request->input('role_' . $role->id)) {
                    $user->assignRole($role->name);
                } else {
                    $user->removeRole($role->name);
                }
            }
            $user->load([
                'roles' => function ($query) {
                    $query->where('status', 1);
                },
            ]);

            $this->userRepo->update($id, [
                'status' => $request->input('status'),
                'is_lock' => $request->input('is_lock')
            ]);

            $responseData = [
                'status' => 200,
                'success' => true,
                'message' => 'The user successfully updated',
                'data' => ['user_update' => $user]
            ];
            return response()->json($responseData);
        } else {
            $responseData = [
                'status' => 200,
                'success' => true,
                'message' => 'The user not found'
            ];
            return response()->json($responseData);
        }
    }

    // update user
    public function adminChangePasswordUser($id, Request $request)
    {
        $user = User::find($id);
        $password = $request->input('password');
        $repassword = $request->input('repassword');
        if ($password !== $repassword or !$password) {
            $responseData = ['status' => 200, 'success' => true, 'message' => 'The user false to updated'];
            return response()->json($responseData);
        }
        $user->password = Hash::make($password);
        $user->save();
        $responseData = ['status' => 200, 'success' => true, 'message' => 'The user successfully updated'];
        return response()->json($responseData);
    }

    // update user
    public function updateUser(Request $request)
    {
        $user = $request->user();
        $userUpdate = User::find($user->id);
        $userUpdate->last_name = $request->input('last_name');
        $userUpdate->first_name = $request->input('first_name');
        $userUpdate->phone_number = $request->input('phone_number');
        $userUpdate->address = $request->input('address');
        $userUpdate->status = $request->input('status');
        $userUpdate->is_lock = $request->input('is_lock');
        $userUpdate->save();
        $responseData = ['status' => 200, 'success' => true, 'message' => 'The user successfully updated'];
        return response()->json($responseData);
    }

    /**
     * Xử lý yêu cầu đăng nhập.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    // public function userChangePassword(Request $request)
    // {
    //     $user = $request->user();
    //     $userUpdate = User::find($user->id);
    //     // return response()->json($user->password);
    //     if (!Hash::check($request->input('password'), $user->password)) {
    //         $responseData = ['status' => 200, 'success' => true, 'message' => 'Password false'];
    //         return response()->json($responseData);

    //     }
    //     $passwordNew = $request->input('password_new');
    //     $repasswordNew = $request->input('repassword_new');
    //     if ($passwordNew !== $repasswordNew or !$passwordNew) {
    //         $responseData = ['status' => 200, 'success' => true, 'message' => 'The user false to updated'];
    //         return response()->json($responseData);
    //     }
    //     $user->password = Hash::make($passwordNew);
    //     $user->save();
    //     $responseData = ['status' => 200, 'success' => true, 'message' => 'The user successfully updated'];
    //     return response()->json($responseData);
    // }

    public function userChangePassword(Request $request)
    {
        $user = $request->user();

        // Validate the request inputs
        $request->validate([
            'password' => 'required|string',
            'password_new' => 'required|string|min:6|',
        ]);

        // Check if the current password is correct
        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Mật khẩu cũ không đúng !'
            ]);
        }

        // Check if the new password and confirmation match
        $passwordNew = $request->input('password_new');
        $repasswordNew = $request->input('repassword_new');

        if ($passwordNew !== $repasswordNew) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Nhập lại mật khẩu không khớp !'
            ]);
        }

        // Update the user's password
        $user->password = Hash::make($passwordNew);
        $user->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Thay đổi mật khẩu thành công !'
        ]);
    }


    /**
     * Get all roles.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function allRoles(Request $request)
    {
        // $rolesWithPermissions = Role::with('permissions')->get();
        $rolesWithPermissions = Role::with(['permissions' => function ($query) {
            $query->where('status', 1);
        }])->get();
        $permissions = Permission::where('status', 1)->get();
        $responseData = [
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => ["roles" => $rolesWithPermissions, "permissions" => $permissions]
        ];
        return response()->json($responseData);
    }

    /**
     * add roles.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addRole(Request $request)
    {
        $role = Role::create([
            'name' => $request->input('name'), // Thiết lập tên cho role
            'description' => $request->input('description'), // Thiết lập mô tả cho role
            'guard_name' => 'web',
            // Các thuộc tính khác của role
        ]);
        $responseData = [
            'status' => 200,
            'success' => true,
            'message' => 'The role successfully added'
        ];
        return response()->json($responseData);
    }

    /**
     * edit roles.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateRole($id, Request $request)
    {
        $permissions = Permission::where('status', 1)->get();
        $role = Role::find($id);
        if ($role) {
            foreach ($permissions as $permission) {
                if ($request->has('permission_' . $permission->id) && $request->input('permission_' . $permission->id) == true) {
                    $role->givePermissionTo([$permission->name]);
                } else {
                    $role->revokePermissionTo([$permission->name]);
                }
            }
            $role->description = $request->input('description'); // Cập nhật giá trị của trường description
            $role->name = $request->input('name');
            $role->save(); // Lưu lại thay đổi vào cơ sở dữ liệu
        } else {
            $responseData = [
                'status' => 200,
                'success' => false,
                'message' => 'The role not found'
            ];
            return response()->json($responseData);
        }


        $responseData = [
            'status' => 200,
            'success' => true,
            'message' => 'The role successfully added',
            'data' => ['role_update' => $role]
        ];
        return response()->json($responseData);
    }

    // delete role
    public function updateStatusRole($id, Request $request)
    {

        try {
            // Tìm vai trò dựa trên ID
            $role = Role::findOrFail($id);

            if ($role->name !== 'admin') {
                // Xóa vai trò
                $statusOld = $role->status;
                $statusNew = $statusOld == 1 ? 0 : 1;
                $role->status = $statusNew;
                $role->save();

                // Thông báo thành công
                $responseData = [
                    'status' => 200,
                    'success' => true,
                    'message' => 'The role successfully deleted'
                ];
            } else {
                // Thông báo lỗi nếu role.name là 'admin'
                $responseData = [
                    'status' => 200,
                    'success' => false,
                    'message' => 'Cannot delete role with name "admin"'
                ];
            }
            return response()->json($responseData);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu cần thiết
            $responseData = [
                'status' => 200,
                'success' => false,
                'message' => 'False to delete role'
            ];
            return response()->json($responseData);
        }
    }

    /**
     * Get all permissions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function allPermissions(Request $request)
    {
        $permissions = Permission::get();
        $responseData = [
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => ["permissions" => $permissions]
        ];
        return response()->json($responseData);
    }

    /**
     * add roles.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addPermission(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->input('name'), // Thiết lập tên cho role
            'description' => $request->input('description'), // Thiết lập mô tả cho role
            'guard_name' => 'web',
            // Các thuộc tính khác của role
        ]);
        $responseData = [
            'status' => 200,
            'success' => true,
            'message' => 'The permission successfully added'
        ];
        return response()->json($responseData);
    }

    /**
     * edit permission.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updatePermission($id, Request $request)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->description = $request->input('description'); // Cập nhật giá trị của trường description
            $permission->name = $request->input('name');
            $permission->save(); // Lưu lại thay đổi vào cơ sở dữ liệu
        } else {
            $responseData = [
                'status' => 200,
                'success' => false,
                'message' => 'The permission not found'
            ];
            return response()->json($responseData);
        }


        $responseData = [
            'status' => 200,
            'success' => true,
            'message' => 'The permission successfully added',
            'data' => ['permission_update' => $permission]
        ];
        return response()->json($responseData);
    }

    // update permission
    public function updateStatusPermission($id, Request $request)
    {

        try {
            // Tìm vai trò dựa trên ID
            $permission = Permission::findOrFail($id);

            $statusOld = $permission->status;
            $statusNew = $statusOld == 1 ? 0 : 1;
            $permission->status = $statusNew;
            $permission->save();

            // Thông báo thành công
            $responseData = [
                'status' => 200,
                'success' => true,
                'message' => 'The permission successfully update'
            ];
            return response()->json($responseData);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu cần thiết
            $responseData = [
                'status' => 200,
                'success' => false,
                'message' => 'False to update permision'
            ];
            return response()->json($responseData);
        }
    }

    public function getUserOptions(): \Illuminate\Http\JsonResponse
    {
        $userOptions = $this->userRepo->getUserOptions();

        $responseData = [
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $userOptions
        ];

        return response()->json($responseData);
    }
}
