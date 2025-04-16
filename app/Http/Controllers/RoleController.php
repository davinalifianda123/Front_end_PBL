<?php
namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        // Mengambil data yang flag-nya 1
        $roles = Role::where('flag', 1)->paginate(10);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        // Menggunakan database transaction dengan try-catch
        try {
            return DB::transaction(function () use ($request) {
                Role::create($request->validated());
                return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat!');
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return redirect()->route('roles.index')
                ->with('error', 'Gagal membuat role. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        // Memastikan hanya role dengan flag=1 yang dapat ditampilkan
        if ($role->flag != 1) {
            return redirect()->route('roles.index')
                ->with('error', 'Role tidak ditemukan.');
        }
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        // Memastikan hanya role dengan flag=1 yang dapat diedit
        if ($role->flag != 1) {
            return redirect()->route('roles.index')
                ->with('error', 'Role tidak ditemukan.');
        }
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        // Memastikan hanya role dengan flag=1 yang dapat diupdate
        if ($role->flag != 1) {
            return redirect()->route('roles.index')
                ->with('error', 'Role tidak ditemukan.');
        }
        
        // Menggunakan database transaction dengan try-catch
        try {
            return DB::transaction(function () use ($request, $role) {
                $role->update($request->validated());
                return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui!');
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return redirect()->route('roles.index')
                ->with('error', 'Gagal memperbarui role. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Memastikan hanya role dengan flag=1 yang dapat dihapus
        if ($role->flag != 1) {
            return redirect()->route('roles.index')
                ->with('error', 'Role tidak ditemukan.');
        }
        
        // Menggunakan database transaction dengan try-catch untuk soft delete
        try {
            return DB::transaction(function () use ($role) {
                // Melakukan soft delete dengan mengubah flag menjadi 0
                $role->flag = 0;
                $role->save();
                
                return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus!');
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return redirect()->route('roles.index')
                ->with('error', 'Gagal menghapus role. Role mungkin sedang digunakan.');
        }
    }
}