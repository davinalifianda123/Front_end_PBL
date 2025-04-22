<?php
namespace App\Http\Controllers;
use App\Models\Toko;
use App\Models\Barang;
use App\Models\Gudang;
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
        $query = Barang::with(['kategori', 'gudang', 'toko']);

        if (auth()->user()->hasRole('Staff')) {
            if (auth()->user()->id_toko) {
                $query->where('id_toko', auth()->user()->id_toko);
            } elseif (auth()->user()->id_gudang) {
                $query->where('id_gudang', auth()->user()->id_gudang);
            }
        }

        if (auth()->user()->hasRole('Supplier')) {
            $query->whereHas('gudang', function ($query) {
                $query->where('is_pusat', true);
            });
        }

        $barangs = $query->orderBy('id')->paginate(10);

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
    public function store(StoreBarangRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $gudangPusat = Gudang::where('is_pusat', true)->first();
                if (!$gudangPusat) {
                    throw new \Exception("Gudang pusat tidak ditemukan.");
                }
            
                $tokos = Toko::whereHas(
                    'jenisToko',
                    fn($query) => $query->where('nama_jenis_toko', '=', 'Toko Perusahaan')
                )->get();
                $gudangsLain = Gudang::where('id', '!=', $gudangPusat->id)->get();
            
                $validated = $request->validated();
            
                $barangParent = Barang::create(array_merge($validated, [
                    'id_parent_barang' => null,
                    'id_gudang' => $gudangPusat->id,
                    'id_toko' => null,
                ]));
            
                $barangTokoData = [];
                foreach ($tokos as $toko) {
                    $jenisToko = $toko->jenisToko->nama_jenis_toko;

                    if ($jenisToko == 'Toko Perusahaan') {
                        $barangTokoData[] = array_merge($validated, [
                            'id_toko' => $toko->id,
                            'id_gudang' => null,
                            'id_parent_barang' => $barangParent->id,
                        ]);
                    }
                }
            
                $barangGudangData = [];
                foreach ($gudangsLain as $gudang) {
                    $barangGudangData[] = array_merge($validated, [
                        'id_toko' => null,
                        'id_gudang' => $gudang->id,
                        'id_parent_barang' => $barangParent->id,
                    ]);
                }
            
                $totalBarangData = array_merge($barangGudangData, $barangTokoData);
                Barang::insert($totalBarangData);
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
        $gudangs = Gudang::all();

        return view('barangs.edit', compact('barang', 'kategoris', 'gudangs'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        try {
            DB::transaction(function () use ($request, $barang) {
                $barang->update($request->validated());
                
                if ($barang->childBarang()->exists()) {
                    $barang->childBarang()->update($request->validated());
                }
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

                if ($barang->childBarang()->exists()) {
                    $barang->childBarang()->update(['flag' => 0]);
                }
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

                if ($barang->childBarang()->exists()) {
                    $barang->childBarang()->update(['flag' => 1]);
                }
            });

            return redirect()->route('barangs.index')
                ->with('success', "Barang {$barang->nama_barang} berhasil diaktifkan!");
        } catch (\Exception $e) {
            return redirect()->route('barangs.index')
                ->with('error', "Terjadi kesalahan saat mengaktifkan barang {$barang->nama_barang}: {$e->getMessage()}");
        }
    }
}