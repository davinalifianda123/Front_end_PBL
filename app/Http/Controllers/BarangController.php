<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Gudang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the product.
     */
    public function index()
    {
        $barangs = Barang::with(['kategori', 'gudang'])->orderBy('id')->paginate(10);
        return view('barangs.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = KategoriBarang::all();
        $gudangs = Gudang::all();
        return view('barangs.create', compact('categories', 'gudangs'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_barangs,id',
            'id_gudang' => 'required|exists:gudangs,id',
            'berat' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
        ]);

        Barang::create($request->all());

        return redirect()->route('barangs.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Display the specified product.
     */
    public function show(Barang $barang)
    {
        return view('barangs.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Barang $barang)
    {
        $kategoris = KategoriBarang::all();
        $gudangs = Gudang::all();
        return view('barangs.edit', compact('barang', 'kategoris', 'gudangs'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_barangs,id',
            'id_gudang' => 'required|exists:gudangs,id',
            'jumlah_stok' => 'required|integer|min:0',
            'berat' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
        ]);

        $barang->update($request->all());

        return redirect()->route('barangs.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barangs.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}