<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserCanEdit;
use App\Http\Requests\UserRequest;
use App\Role;
use App\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(UserCanEdit::class);
    }

    public function manage(request $request)
    {
        $Users = User::with('Role')->get();
        return view('users.index', compact('Users'));
    }

    public function newUser()
    {
        $Roles = Role::get();
        $formurl = route('createUser');
        return view('users.addedit', compact('Roles', 'formurl'));
    }

    public function createUser(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('manageUsers');
    }

    public function editUser(User $User)
    {
        $Roles = Role::get();
        $formurl = route('editUser', $User);
        return view('users.addedit', compact('Roles', 'formurl', 'User'));
    }

    public function updateUser(UserRequest $request, User $User)
    {
        $User->update($request->all());

        return redirect()->route('manageUsers');
    }

    public function deleteUser(User $User)
    {
        $User->delete();
        return redirect()->route('manageUsers');
    }
}
