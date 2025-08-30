<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $user = auth()->user();

        // Check permission
        if (!$user->can('user Create')) {
            return redirect()->back()->with('error', 'You do not have permission to Create user.');
        }
              $roles = Role::all();

        // Return the create view with roles
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = auth()->user();

        // Check permission
        if (!$user->can('user Create')) {
            return redirect()->back()->with('error', 'You do not have permission to Create users.');
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign roles
        $user->roles()->sync($request->role);

        // Redirect with success message
        return redirect()->route('admin.users.index')
                     ->with('success', 'User created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $authuser = auth()->user();

        // Check permission
        if (!$authuser->can('user Edit')) {
            return redirect()->back()->with('error', 'You do not have permission to edit users.');
        }
        $roles = Role::all();

        return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $authuser = auth()->user();

        // Check permission
        if (!$authuser->can('user Edit')) {
            return redirect()->back()->with('error', 'You do not have permission to edit users.');
        }
        $data = $request->validate([
            'role' => ['required','string',],
        ]);
         // Update user fields
        $user->name = $request->name;
        $user->email = $request->email;

        // if ($request->filled('password')) {
        //     $user->password = Hash::make($request->password);
        // }

        $user->save();

        // Sync roles by IDs
        $user->roles()->sync($request->role);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $authuser = auth()->user();

        // Check permission
        if (!$authuser->can('user Delete')) {
            return redirect()->back()->with('error', 'You do not have permission to edit posts.');
        }
        $user->delete();
        return back()->with('success','User deleted.');
    }
}
