<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.users.index', compact('roles'));
    }

    public function ajaxList()
    {
        $users = User::with('roles');

        return DataTables::of($users)
            ->addColumn('roles', fn($user) => $user->roles->pluck('name')->implode(', '))
            ->addColumn('actions', function ($user) {
                return '
                    <button class="btn btn-warning btn-sm editUser"
                            data-id="'.$user->id.'"
                            data-name="'.$user->name.'"
                            data-email="'.$user->email.'"
                            data-roles="'.implode(',', $user->roles->pluck('name')->toArray()).'">
                        Düzenle
                    </button>
                    <button class="btn btn-danger btn-sm deleteUser" data-id="'.$user->id.'">Sil</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'roles' => 'array|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles($request->roles);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'roles' => 'array|exists:roles,name',
        ]);

        $data = $request->only('name', 'email');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return response()->json(['success' => true]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true]);
    }
}
