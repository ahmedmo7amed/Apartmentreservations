<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::latest()->simplePaginate(10);
        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        User::create(array_merge(
            $request->validated(),
            ['password' => Hash::make($request->password)]
        ));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function update(User $user, StoreUserRequest $request)
    {
        $user->update(array_merge(
            $request->validated(),
            ['password' => Hash::make($request->password)]
        ));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function show(User $user)
    {
        return Inertia::render('FlatsDetails/FlatsDetails', [
            'user' => $user,
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }
}
