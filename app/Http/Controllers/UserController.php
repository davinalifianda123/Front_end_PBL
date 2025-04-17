<?php
namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the user.
     */
    public function index(Request $request)
    {
        $query = User::query()->with('role')->where('flag', 1);
        
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
        // Mengambil hanya role yang aktif (jika ada flag pada role)
        $roles = Role::when(Schema::hasColumn('roles', 'flag'), function($query) {
            return $query->where('flag', 1);
        })->get();
        
        return view('users.index', compact('users', 'roles'));
    }
    
    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Mengambil hanya role yang aktif (jika ada flag pada role)
        $roles = Role::when(Schema::hasColumn('roles', 'flag'), function($query) {
            return $query->where('flag', 1);
        })->get();
        
        return view('users.create', compact('roles'));
    }
    
    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();
                $validated['password'] = Hash::make($validated['password']);
                $validated['email_verified_at'] = null;
                $validated['flag'] = 1; // Memastikan flag diset ke 1
                
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
        // Jika user sudah di-soft delete, redirect ke index
        if ($user->flag == 0) {
            return redirect()->route('users.index')
                ->with('error', 'Pengguna tidak ditemukan atau sudah dihapus.');
        }
        
        return view('users.show', compact('user'));
    }
    
    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Jika user sudah di-soft delete, redirect ke index
        if ($user->flag == 0) {
            return redirect()->route('users.index')
                ->with('error', 'Pengguna tidak ditemukan atau sudah dihapus.');
        }
        
        // Mengambil hanya role yang aktif (jika ada flag pada role)
        $roles = Role::when(Schema::hasColumn('roles', 'flag'), function($query) {
            return $query->where('flag', 1);
        })->get();
        
        return view('users.edit', compact('user', 'roles'));
    }
    
    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Jika user sudah di-soft delete, redirect ke index
        if ($user->flag == 0) {
            return redirect()->route('users.index')
                ->with('error', 'Pengguna tidak ditemukan atau sudah dihapus.');
        }
        
        try {
            DB::transaction(function () use ($request, $user) {
                $validated = $request->validated();
                
                if ($request->filled('password')) {
                    $request->validate([
                        'password' => 'string|min:8|confirmed',
                    ]);
                    $validated['password'] = Hash::make($request->password);
                } else {
                    $validated['password'] = $user->password;
                }
                
                // Pastikan flag tetap 1 saat update
                $validated['flag'] = 1;
                
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
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan');
        }
        
        try {
            DB::transaction(function () use ($user) {
                // Soft delete dengan mengubah flag menjadi 0
                $user->update(['flag' => 0]);
            });

            return redirect()->route('users.index')
                ->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}

// Supplier Controller

// <?php

// namespace App\Http\Controllers;

// use App\Models\Supplier;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class SupplierController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         $suppliers = Supplier::where('flag', 1)->get();
//         return view('suppliers.index', compact('suppliers'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         return view('suppliers.create');
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         $validatedData = $request->validate([
//             'nama_toko_supplier' => 'required|max:255',
//             'alamat' => 'required',
//             'no_telepon' => 'required|max:15',
//             'email' => 'required|email|max:255',
//             'contact_person' => 'required|max:255',
//         ]);

//         try {
//             DB::transaction(function () use ($validatedData) {
//                 Supplier::create($validatedData);
//             });
            
//             return redirect()->route('suppliers.index')
//                 ->with('success', 'Supplier berhasil ditambahkan.');
//         } catch (\Exception $e) {
//             return redirect()->back()
//                 ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
//                 ->withInput();
//         }
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(Supplier $supplier)
//     {
//         return view('suppliers.show', compact('supplier'));
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(Supplier $supplier)
//     {
//         return view('suppliers.edit', compact('supplier'));
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, Supplier $supplier)
//     {
//         $validatedData = $request->validate([
//             'nama_toko_supplier' => 'required|max:255',
//             'alamat' => 'required',
//             'no_telepon' => 'required|max:15',
//             'email' => 'required|email|max:255',
//             'contact_person' => 'required|max:255',
//         ]);

//         try {
//             DB::transaction(function () use ($supplier, $validatedData) {
//                 $supplier->update($validatedData);
//             });
            
//             return redirect()->route('suppliers.index')
//                 ->with('success', 'Data supplier berhasil diperbarui.');
//         } catch (\Exception $e) {
//             return redirect()->back()
//                 ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
//                 ->withInput();
//         }
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(Supplier $supplier)
//     {
//         try {
//             DB::transaction(function () use ($supplier) {
//                 // Soft delete dengan mengubah flag menjadi 0
//                 $supplier->update(['flag' => 0]);
//             });
            
//             return redirect()->route('suppliers.index')
//                 ->with('success', 'Supplier berhasil dihapus.');
//         } catch (\Exception $e) {
//             return redirect()->back()
//                 ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
//         }
//     }
// }