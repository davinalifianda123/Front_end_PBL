<?php
namespace App\Http\Controllers;
use App\Models\Toko;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\GudangDanToko;
use App\Models\KategoriBarang;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Barang\StoreBarangRequest;
use App\Http\Requests\Barang\UpdateBarangRequest;

class BarangController extends Controller
{
    /**
     * Display a listing of the product.
     */
    public function index()
    {
        // $query = Barang::with(['kategori', 'gudang', 'toko']);
        $query = Barang::with(['kategori']);

        $barangs = $query->orderBy('id')->paginate(10);

        return view('barangs.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = KategoriBarang::all();
        $gudangTokos = GudangDanToko::all();

        return view('barangs.create', compact('categories', 'gudangTokos'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreBarangRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Barang::insert($request->validated);
            });

            return redirect()->route('barangs.index')
                ->with('success', "Barang {$request->nama_barang} berhasil ditambahkan!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', "Terjadi kesalahan saat menyimpan barang {$request->nama_barang}: {$e->getMessage()}")
                ->withInput();
        }
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

        return view('barangs.edit', compact('barang', 'kategoris'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        try {
            DB::transaction(function () use ($request, $barang) {
                $barang->update($request->validated());
            });

            return redirect()->route('barangs.index')
                ->with('success', "Barang {$barang->nama_barang} berhasil diperbarui!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', "Terjadi kesalahan saat memperbarui barang {$barang->nama_barang}: {$e->getMessage()}")
                ->withInput();
        }
    }

    /**
     * Deactivate the specified product from storage.
     */
    public function deactivate(Barang $barang)
    {
        try {
            DB::transaction(function () use ($barang) {
                $barang->update(['flag' => 0]);
            });

            return redirect()->route('barangs.index')
                ->with('success', "Barang {$barang->nama_barang} berhasil dinonaktifkan!");
        } catch (\Exception $e) {
            return redirect()->route('barangs.index')
                ->with('error', "Terjadi kesalahan saat menonaktifkan barang {$barang->nama_barang}: {$e->getMessage()}");
        }
    }

    /**
     * Activate the specified product from storage.
     */
    public function activate(Barang $barang)
    {
        try {
            DB::transaction(function () use ($barang) {
                $barang->update(['flag' => 1]);
            });

            return redirect()->route('barangs.index')
                ->with('success', "Barang {$barang->nama_barang} berhasil diaktifkan!");
        } catch (\Exception $e) {
            return redirect()->route('barangs.index')
                ->with('error', "Terjadi kesalahan saat mengaktifkan barang {$barang->nama_barang}: {$e->getMessage()}");
        }
    }
}