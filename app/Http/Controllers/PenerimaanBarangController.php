<?php

namespace App\Http\Controllers;

use App\Models\PenerimaanBarang;
use App\Models\DetailPenerimaanBarang;
use App\Models\Supplier;
use App\Models\Gudang;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PenerimaanBarang::with(['supplier', 'gudang', 'detailPenerimaanBarang']);

        // Filter pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('supplier', function ($subQuery) use ($search) {
                    $subQuery->where('nama_toko_supplier', 'like', '%' . $search . '%')->where('flag', 1);
                })
                    ->orWhereHas('gudang', function ($subQuery) use ($search) {
                        $subQuery->where('nama_gudang', 'like', '%' . $search . '%')->where('flag', 1);
                    })
                    ->orWhere('tanggal_penerimaan', 'like', '%' . $search . '%');
            });
        }

        $penerimaanBarangs = $query->orderBy('tanggal_penerimaan', 'desc')->paginate(10);

        return view('penerimaan_barang.index', compact('penerimaanBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::where('flag', 1)->orderBy('nama_toko_supplier')->get();
        $gudangs = Gudang::where('flag', 1)->orderBy('nama_gudang')->get();
        $barangs = Barang::where('flag', 1)->orderBy('nama_barang')->get();

        return view('penerimaan_barang.create', compact('suppliers', 'gudangs', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data penerimaan barang
        $request->validate([
            'id_supplier' => 'required|exists:suppliers,id',
            'id_gudang' => 'required|exists:gudangs,id',
            'tanggal_penerimaan' => 'required|date',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barangs,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|numeric|min:1',
            'harga_beli' => 'required|array|min:1',
            'harga_beli.*' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Simpan penerimaan barang
            $penerimaanBarang = PenerimaanBarang::create([
                'id_supplier' => $request->id_supplier,
                'id_gudang' => $request->id_gudang,
                'tanggal_penerimaan' => $request->tanggal_penerimaan,
            ]);

            // Simpan detail penerimaan barang
            $barangCount = count($request->barang_id);

            for ($i = 0; $i < $barangCount; $i++) {
                $barang = Barang::where('id', $request->barang_id[$i])->first();
                if ($barang) {
                    $barang->jumlah_stok += $request->jumlah[$i];
                    $barang->save();
                }

                DetailPenerimaanBarang::create([
                    'id_penerimaan_barang' => $penerimaanBarang->id,
                    'id_barang' => $request->barang_id[$i],
                    'jumlah' => $request->jumlah[$i],
                    'harga_beli' => $request->harga_beli[$i],
                ]);
            }

            DB::commit();

            return redirect()->route('penerimaan-barang.index', $penerimaanBarang)
                ->with('success', 'Penerimaan barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PenerimaanBarang $penerimaanBarang)
    {
        $penerimaanBarang->load(['supplier', 'gudang', 'detailPenerimaanBarang.barang']);

        return view('penerimaan_barang.show', compact('penerimaanBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenerimaanBarang $penerimaanBarang)
    {
        $penerimaanBarang->load(['detailPenerimaanBarang.barang']);
        $suppliers = Supplier::where('flag', 1)->orderBy('nama_toko_supplier')->get();
        $gudangs = Gudang::where('flag', 1)->orderBy('nama_gudang')->get();

        return view('penerimaan_barang.edit', compact('penerimaanBarang', 'suppliers', 'gudangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenerimaanBarang $penerimaanBarang)
    {
        // Validasi data penerimaan barang
        $request->validate([
            'id_supplier' => 'required|exists:suppliers,id',
            'id_gudang' => 'required|exists:gudangs,id',
            'tanggal_penerimaan' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            // Update penerimaan barang
            $penerimaanBarang->update([
                'id_supplier' => $request->id_supplier,
                'id_gudang' => $request->id_gudang,
                'tanggal_penerimaan' => $request->tanggal_penerimaan,
            ]);

            DB::commit();

            return redirect()->route('penerimaan-barang.index')
                ->with('success', 'Penerimaan barang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui penerimaan barang: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaanBarang $penerimaanBarang)
    {
        DB::beginTransaction();

        try {
            $detailPenerimaanBarangs = DetailPenerimaanBarang::where('id_penerimaan_barang', $penerimaanBarang->id)->get();

            foreach ($detailPenerimaanBarangs as $detail) {
                $barang = Barang::find($detail->id_barang);
                if ($barang) {
                    $barang->jumlah_stok = max(0, $barang->jumlah_stok - $detail->jumlah);
                    $barang->save();
                }
            }

            $penerimaanBarang->delete();

            DB::commit();

            return redirect()->route('penerimaan-barang.index')
                ->with('success', 'Penerimaan barang dan semua detailnya berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a detail record.
     */
    public function editDetail(DetailPenerimaanBarang $detailPenerimaan)
    {
        $detailPenerimaan->load(['penerimaanBarang', 'barang']);
        $barangs = Barang::where('flag', 1)->orderBy('nama_barang')->get();
        $suppliers = Supplier::where('flag', 1)->get();
        $gudangs = Gudang::where('flag', 1)->get();

        return view('detail_penerimaan_barang.edit', compact('detailPenerimaan', 'barangs', 'suppliers', 'gudangs'));
    }

    /**
     * Update the specified detail record.
     */
    public function updateDetail(Request $request, DetailPenerimaanBarang $detailPenerimaan)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $barangData = Barang::where('id', $request->barang_id)->first();
            $barangData->jumlah_stok -= $detailPenerimaan->jumlah;
            $barangData->jumlah_stok += $request->jumlah;
            $barangData->save();

            $detailPenerimaan->update([
                'id_barang' => $request->barang_id,
                'jumlah' => $request->jumlah,
                'harga_beli' => $request->harga_beli,
            ]);

            DB::commit();

            return redirect()->route('penerimaan-barang.show', $detailPenerimaan->id_penerimaan_barang)
                ->with('success', 'Detail penerimaan barang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new detail record for existing penerimaan.
     */
    public function createDetail(PenerimaanBarang $penerimaanBarang)
    {
        $barangs = Barang::where('flag', 1)->orderBy('nama_barang')->get();

        return view('detail_penerimaan_barang.create', compact('penerimaanBarang', 'barangs'));
    }

    /**
     * Store a newly created detail record.
     */
    public function storeDetail(Request $request, PenerimaanBarang $penerimaanBarang)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        try {
            $barangData = Barang::where('id', $request->barang_id)->first();
            $barangData->jumlah_stok += $request->jumlah;
            $barangData->save();

            DetailPenerimaanBarang::create([
                'id_penerimaan_barang' => $penerimaanBarang->id,
                'id_barang' => $request->barang_id,
                'jumlah' => $request->jumlah,
                'harga_beli' => $request->harga_beli,
            ]);

            return redirect()->route('penerimaan-barang.show', $penerimaanBarang->id)
                ->with('success', 'Detail penerimaan barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified detail record.
     */
    public function destroyDetail(DetailPenerimaanBarang $detailPenerimaan)
    {
        $penerimaanBarangId = $detailPenerimaan->id_penerimaan_barang;

        try {
            $barangData = Barang::where('id', $detailPenerimaan->barang->id)->first();
            $barangData->jumlah_stok -= $detailPenerimaan->jumlah;
            $barangData->save();

            $detailPenerimaan->delete();

            return redirect()->route('penerimaan-barang.show', $penerimaanBarangId)
                ->with('success', 'Detail penerimaan barang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Show detailed information for a specific detail record.
     */
    public function showDetail(DetailPenerimaanBarang $detailPenerimaan)
    {
        $detailPenerimaan->load(['penerimaanBarang', 'barang']);

        return view('detail_penerimaan_barang.show', compact('detailPenerimaan'));
    }
}