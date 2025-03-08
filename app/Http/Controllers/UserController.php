<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        // Only administrateurs can manage users
        $this->middleware(['role:administrateur'])->except(['show', 'edit', 'update']);
    }
    
    //Display
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

  
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

   //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'nullable|string',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephone' => $request->telephone,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

  
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        
        // Users can only view their own profile unless they are admin
        if (auth()->user()->id != $user->id && !auth()->user()->hasRole('administrateur')) {
            abort(403);
        }
        
        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        
        // Users can only edit their own profile unless they are admin
        if (auth()->user()->id != $user->id && !auth()->user()->hasRole('administrateur')) {
            abort(403);
        }
        
        $roles = Role::all();
        $userRole = $user->roles->pluck('name')->first();
        
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    //Update
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        // Users can only update their own profile unless they are admin
        if (auth()->user()->id != $user->id && !auth()->user()->hasRole('administrateur')) {
            abort(403);
        }
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'telephone' => 'nullable|string',
        ];
        
        // Only admins can change roles
        if (auth()->user()->hasRole('administrateur')) {
            $rules['role'] = 'required|exists:roles,name';
        }
        
        // Password is optional during update
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }
        
        $request->validate($rules);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        // Only admins can update roles
        if (auth()->user()->hasRole('administrateur') && $request->has('role')) {
            $user->syncRoles([$request->role]);
        }
        
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

   
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}