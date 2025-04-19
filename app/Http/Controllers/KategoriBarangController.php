<?php
namespace App\Http\Controllers;
use App\Http\Requests\Kategori\StoreKategoriRequest;
use App\Http\Requests\Kategori\UpdateKategoriRequest;
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
        $categories = KategoriBarang::orderBy('id')->paginate(10);
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
    public function store(StoreKategoriRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                KategoriBarang::create($request->validated());

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
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(KategoriBarang $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(UpdateKategoriRequest $request, KategoriBarang $category)
    {
        try {
            return DB::transaction(function () use ($request, $category) {
                $category->update($request->validated());
                
                return redirect()->route('categories.index')
                    ->with('success', 'Kategori barang berhasil diperbarui.');
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return redirect()->route('categories.index')
                ->with('error', 'Gagal memperbarui kategori. Silakan coba lagi.');
        }
    }

    /**
     * Deactivate the specified category from storage.
     */
    public function deactivate(KategoriBarang $category)
    {   
        try {
            return DB::transaction(function () use ($category) {
                $category->update(['flag' => 0]);
                
                return redirect()->back()
                    ->with('success', "Kategori barang {$category->nama_kategori_barang} berhasil dinonaktifkan.");
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', "Gagal menonaktifkan kategori barang {$category->nama_kategori_barang}.");
        }
    }

    /**
     * Activate the specified category from storage.
     */
    public function activate(KategoriBarang $category)
    {
        try {
            return DB::transaction(function () use ($category) {
                $category->update(['flag' => 1]);
                
                return redirect()->back()
                    ->with('success', "Kategori barang {$category->nama_kategori_barang} berhasil diaktifkan.");
            }, 3); // Maksimal 3 percobaan jika terjadi deadlock
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', "Gagal mengaktifkan kategori barang {$category->nama_kategori_barang}.");
        }
    }
}