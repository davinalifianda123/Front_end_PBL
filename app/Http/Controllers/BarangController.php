<?php
namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Gudang;
use Illuminate\Http\Request;
use App\Models\KategoriBarang;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the product.
     */
    public function index()
    {
        // Mengambil hanya barang dengan flag = 1 (aktif)
        $barangs = Barang::with(['kategori', 'gudang'])
                  ->where('flag', 1)
                  ->orderBy('id')
                  ->paginate(10);
                  
        return view('barangs.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // Mengambil hanya kategori dan gudang yang aktif (flag = 1)
        $categories = KategoriBarang::where('flag', 1)->get();
        $gudangs = Gudang::where('flag', 1)->get();
        
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
        
        try {
            DB::transaction(function () use ($request) {
                // Pastikan flag diset ke 1 saat membuat barang baru
                $data = $request->all();
                $data['flag'] = 1;
                
                Barang::create($data);
            });
            
            return redirect()->route('barangs.index')
                ->with('success', 'Barang berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Barang $barang)
    {
        // Jika barang sudah di-soft delete, redirect ke index
        if ($barang->flag == 0) {
            return redirect()->route('barangs.index')
                ->with('error', 'Barang tidak ditemukan atau sudah dihapus.');
        }
        
        return view('barangs.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Barang $barang)
    {
        // Jika barang sudah di-soft delete, redirect ke index
        if ($barang->flag == 0) {
            return redirect()->route('barangs.index')
                ->with('error', 'Barang tidak ditemukan atau sudah dihapus.');
        }
        
        // Mengambil hanya kategori dan gudang yang aktif (flag = 1)
        $kategoris = KategoriBarang::where('flag', 1)->get();
        $gudangs = Gudang::where('flag', 1)->get();
        
        return view('barangs.edit', compact('barang', 'kategoris', 'gudangs'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        // Jika barang sudah di-soft delete, redirect ke index
        if ($barang->flag == 0) {
            return redirect()->route('barangs.index')
                ->with('error', 'Barang tidak ditemukan atau sudah dihapus.');
        }
        
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_barangs,id',
            'id_gudang' => 'required|exists:gudangs,id',
            'jumlah_stok' => 'required|integer|min:0',
            'berat' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
        ]);
        
        try {
            DB::transaction(function () use ($request, $barang) {
                // Pastikan flag tetap 1 saat update
                $data = $request->all();
                $data['flag'] = 1;
                
                $barang->update($data);
            });
            
            return redirect()->route('barangs.index')
                ->with('success', 'Barang berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Barang $barang)
    {
        try {
            DB::transaction(function () use ($barang) {
                // Soft delete dengan mengubah flag menjadi 0
                $barang->update(['flag' => 0]);
            });
           
            return redirect()->route('barangs.index')
                ->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('barangs.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}