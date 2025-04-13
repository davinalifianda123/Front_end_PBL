<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barangs',
        ]);

        KategoriBarang::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori barang berhasil ditambahkan.');
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
    public function update(Request $request, KategoriBarang $category)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barangs,nama_kategori,' . $category->id,
        ]);

        $category->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori barang berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(KategoriBarang $category)
    {
        try {
            $category->delete();
            return redirect()->route('categories.index')
                ->with('success', 'Kategori barang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')
                ->with('error', 'Gagal menghapus kategori. Kategori mungkin sedang digunakan.');
        }
    }
}