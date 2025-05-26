<?php

namespace App\Http\Controllers;

use App\Http\Requests\GudangDanToko\StoreGudangDanTokoRequest;
use App\Http\Requests\GudangDanToko\UpdateGudangDanTokoRequest;
use App\Models\GudangDanToko;
use Illuminate\Support\Facades\DB;

class GudangDanTokoController extends Controller
{
    public function index()
    {
        $semuaBangunan = GudangDanToko::orderBy('id')->paginate(10);
        return view('gudangs_dan_tokos.index', compact('semuaBangunan'));
    }

    public function gudangs()
    {
        $gudangs = GudangDanToko::where('kategori_bangunan', 0)->paginate(10);
        return view('gudangs_dan_tokos.gudangs', compact('gudangs'));
    }

    public function suppliers()
    {
        $suppliers = GudangDanToko::where('kategori_bangunan', 1)->paginate(10);
        return view('gudangs_dan_tokos.suppliers', compact('suppliers'));
    }

    public function tokos()
    {
        $tokos = GudangDanToko::where('kategori_bangunan', 2)->paginate(10);
        return view('gudangs_dan_tokos.tokos', compact('tokos'));
    }

    public function create()
    {
        return view('gudangs_dan_tokos.create');
    }

    public function store(StoreGudangDanTokoRequest $request)
    {
        try {
            DB::transaction(fn () => GudangDanToko::create($request->validated()));
            return redirect()->route('gudangs_dan_tokos.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan: ' . $e->getMessage()]);
        }
    }

    public function show(GudangDanToko $gudangDanToko)
    {
        return view('gudangs_dan_tokos.show', compact('gudangDanToko'));
    }

    public function edit(GudangDanToko $gudangDanToko)
    {
        return view('gudangs_dan_tokos.edit', compact('gudangDanToko'));
    }

    public function update(UpdateGudangDanTokoRequest $request, GudangDanToko $gudangDanToko)
    {
        try {
            DB::transaction(fn () => $gudangDanToko->update($request->validated()));
            return redirect()->route('gudangs_dan_tokos.index')->with('success', "{$gudangDanToko->nama_gudang_toko} berhasil diperbarui.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => "Gagal memperbarui: {$e->getMessage()}"]);
        }
    }

    public function deactivate(GudangDanToko $gudangDanToko)
    {
        if ($gudangDanToko->flag != 1) {
            return redirect()->route('gudangs_dan_tokos.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            DB::transaction(function () use ($gudangDanToko) {
                $gudangDanToko->update(['flag' => 0]);

                if (method_exists($gudangDanToko, 'users') && $gudangDanToko->users()->exists()) {
                    $gudangDanToko->users()->update(['flag' => 0]);
                }
            });

            return redirect()->back()->with('success', "{$gudangDanToko->nama_gudang_toko} berhasil dinonaktifkan.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => "Gagal menonaktifkan: {$e->getMessage()}"]);
        }
    }

    public function activate(GudangDanToko $gudangDanToko)
    {
        if ($gudangDanToko->flag != 0) {
            return redirect()->route('gudangs_dan_tokos.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            DB::transaction(function () use ($gudangDanToko) {
                $gudangDanToko->update(['flag' => 1]);

                if (method_exists($gudangDanToko, 'users') && $gudangDanToko->users()->exists()) {
                    $gudangDanToko->users()->update(['flag' => 1]);
                }
            });

            return redirect()->back()->with('success', "{$gudangDanToko->nama_gudang_toko} berhasil diaktifkan.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => "Gagal mengaktifkan: {$e->getMessage()}"]);
        }
    }
}
