<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        
        $query = User::with('role');
        
        // Apply filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
        
        $users = $query->latest()->paginate(10);
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'is_active' => $request->has('is_active'),
        ]);
        
        // Create related models based on role
        $this->createRoleSpecificModels($user);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        $user->load([
            'role', 
            'player.team', 
            'player.bookings.sport_field', 
            'player.bookings.payment',
            'managedFields',
            'vendor.permits.tournament'
        ]);
        
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];
        
        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        // Don't allow changing own status or role (admin)
        if (Auth::id() !== $user->id) {
            $data['is_active'] = $request->has('is_active');
        }
        
        $user->update($data);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function toggleStatus(User $user)
    {
        // Prevent changing own status (admin)
        if (Auth::id() === $user->id) {
            return redirect()->back()
                ->with('error', 'You cannot change your own status');
        }
        
        $user->is_active = !$user->is_active;
        $user->save();
        
        return redirect()->back()
            ->with('success', 'User status updated successfully');
    }
    
    private function createRoleSpecificModels(User $user)
    {
        // Create related model based on role
        switch ($user->role->name) {
            case 'player':
                $user->player()->create([
                    'member_since' => now(),
                ]);
                break;
                
            case 'admin':
                $user->admin()->create();
                break;
                
            case 'field_manager':
                // Field manager doesn't need a specific model in this implementation
                break;
                
            case 'vendor':
                $user->vendor()->create([
                    'business_type' => 'Other',
                ]);
                break;
        }
    }
}