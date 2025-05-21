<?php
namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use App\Models\GudangDanToko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $q->where('nama_user', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }
        
        if ($request->has('role') && $request->role != '') {
            $query->where('id_role', $request->role);
        }
        
        $users = $query->orderBy('id')->paginate(10);

        $roles = Role::where('flag', 1)->get();
        
        return view('users.index', compact('users', 'roles'));
    }
    
    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        $gudangs = GudangDanToko::all();
        $tokos = GudangDanToko::all();
        
        return view('users.create', compact('roles', 'gudangs', 'tokos'));
    }
    
    /**
     * Store a newly created user in storage.
     */ 
    public function store(StoreUserRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();


                $role = Role::find($validated['id_role']);

                $idJenisToko = [
                    'Supplier' => 2,
                    'Buyer' => 3,
                ];

                if ($role && array_key_exists($role->nama_role, $idJenisToko)) {
                    $tokoData = [
                        'nama_toko' => $validated['nama_user'],
                        'id_jenis_toko' => $idJenisToko[$role->nama_role],
                        'alamat' => $validated['alamat'],
                        'no_telepon' => $validated['no_telepon'],
                    ];

                    $toko = Toko::create($tokoData);
                    $validated['id_toko'] = $toko['id'];    // $validated['id_toko']; could be null or id toko staff
                }

                $validated['password'] = Hash::make($validated['password']);

                User::create($validated);
            });
            
            return redirect()->route('users.index')
                ->with('success', 'Pengguna berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
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
        $roles = Role::where('flag', 1)->get();
        
        return view('users.edit', compact('user', 'roles'));
    }
    
    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {   
        try {
            DB::transaction(function () use ($request, $user) {
                $validated = $request->validated();
                
                if ($request->filled('password') && $request['password'] != $user->password) {
                    $request->validate([
                        'password' => 'string|min:8|confirmed',
                    ]);
                    $validated['password'] = Hash::make($request->password);
                } else {
                    $validated['password'] = $user->password;
                }
                
                $user->update($validated);
            });
            
            return redirect()->route('users.index')
                ->with('success', 'Data pengguna berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Deactivate the specified user from storage.
     */
    public function deactivate(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menonaktifkan akun yang sedang digunakan');
        }
        
        try {
            DB::transaction(function () use ($user) {
                $user->update(['flag' => 0]);
            });

            return redirect()->back()
                ->with('success', "Pengguna {$user->nama_user} berhasil dinonaktifkan");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', "Terjadi kesalahan saat menonaktifkan pengguna {$user->nama_user}: {$e->getMessage()}");
        }
    }

    /**
     * Activate the specified user from storage.
     */
    public function activate(User $user)
    {   
        try {
            DB::transaction(function () use ($user) {
                $user->update(['flag' => 1]);
                $user->toko()->update(['flag' => 1]);
            });

            return redirect()->back()
                ->with('success', "Pengguna {$user->nama_user} berhasil diaktifkan");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', "Terjadi kesalahan saat mengaktifkan pengguna {$user->nama_user}: {$e->getMessage()}");
        }
    }
}