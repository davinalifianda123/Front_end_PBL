<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\KategoriBarang;
use Illuminate\Support\Facades\DB;

class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the category.
     */
    public function index()
    {
        // Mengambil data yang flag-nya 1
        $categories = KategoriBarang::where('flag', 1)->orderBy('id')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barangs',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                KategoriBarang::create([
                    'nama_kategori' => $request->nama_kategori,
                ]);
                
                return redirect()->route('categories.index')
                    ->with('success', 'Kategori barang berhasil ditambahkan.');
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return redirect()->route('categories.index')
                ->with('error', 'Gagal menambahkan kategori. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified category.
     */
    public function show(KategoriBarang $category)
    {
        // Memastikan hanya kategori dengan flag=1 yang dapat ditampilkan
        if ($category->flag != 1) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan.');
        }
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(KategoriBarang $category)
    {
        // Memastikan hanya kategori dengan flag=1 yang dapat diedit
        if ($category->flag != 1) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan.');
        }
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, KategoriBarang $category)
    {
        // Memastikan hanya kategori dengan flag=1 yang dapat diupdate
        if ($category->flag != 1) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan.');
        }
        
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barangs,nama_kategori,' . $category->id,
        ]);

        try {
            return DB::transaction(function () use ($request, $category) {
                $category->update([
                    'nama_kategori' => $request->nama_kategori,
                ]);
                
                return redirect()->route('categories.index')
                    ->with('success', 'Kategori barang berhasil diperbarui.');
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return redirect()->route('categories.index')
                ->with('error', 'Gagal memperbarui kategori. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(KategoriBarang $category)
    {
        // Memastikan hanya kategori dengan flag=1 yang dapat dihapus
        if ($category->flag != 1) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan.');
        }
        
        try {
            return DB::transaction(function () use ($category) {
                // Melakukan soft delete dengan mengubah flag menjadi 0
                $category->flag = 0;
                $category->save();
                
                return redirect()->route('categories.index')
                    ->with('success', 'Kategori barang berhasil dihapus.');
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return redirect()->route('categories.index')
                ->with('error', 'Gagal menghapus kategori. Kategori mungkin sedang digunakan.');
        }
    }
}