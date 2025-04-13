<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the user.
     */
    public function index(Request $request)
    {
        $query = User::query()->with('role');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('role_id', $request->role);
        }

        $users = $query->orderBy('id')->paginate(10);
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = null;

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        } else {
            $validated['password'] = $user->password;
        }

        // dd($validated); // Menambahkan ini untuk memeriksa isi $validated

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Cek apakah user mencoba menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan');
        }
        
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus');
    }
}
