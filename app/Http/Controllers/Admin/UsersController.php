<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Role, State};
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::orderBy('card', 'desc')->paginate(12);
        return view('admin.users.index', compact('users'));
    }


    public function create()
    {
        return view('admin.users.create', [
            'roles' => Role::whereIn('id', [1, 2])->get(),
            'states' => State::whereIn('id', [1, 2])->get()
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'card' => 'required|string|min:3|max:255',
            'name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|min:10|max:15',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'state_id' => 'required|exists:states,id'
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
    }


    public function edit(User $user)
    {
        $roles = Role::whereIn('id', [1, 2])->get();
        $states = State::whereIn('id', [1, 2])->get();
        return view('admin.users.edit', compact('user', 'roles', 'states'));
    }


    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'card' => 'required|string|min:3|max:255|unique:users,card,' . $user->card . ',card',
            'name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $user->card . ',card',
            'phone' => 'required|string|min:10|max:15',
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|in:1,2',
            'state_id' => 'required|in:1,2'
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }


        $user->update($data);
        return redirect()->route('admin.users.edit', $user)->with('success', 'Usuario actualizado correctamente.');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }

}
