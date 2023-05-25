<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UsersRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('services')
            ->paginate(10);

        return view('users.index')->with([
            'users' => $users,
        ]);
    }

    public function create()
    {
        $roles = Role::get();

        return view('users.create')->with([
            'roles' => $roles,
        ]);
    }

    public function store(UsersRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt(Str::random(20))
        ]);

        $user->roles()->sync($request->input('roles_ids'));

        $user->sendWelcomeEmail();

        return redirect(route('users.index'));
    }

    public function edit(User $user)
    {
        $roles = Role::get();
        $user->load('roles');

        return view('users.edit')->with([
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(UsersRequest $request, User $user)
    {
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        $user->roles()->sync($request->input('roles_ids'));

        return redirect(route('users.index'));
    }
}
