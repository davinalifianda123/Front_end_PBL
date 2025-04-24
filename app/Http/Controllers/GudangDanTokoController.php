<?php

namespace App\Http\Controllers;

use App\Http\Requests\GudangDanToko\StoreGudangDanTokoRequest;
use App\Http\Requests\GudangDanToko\UpdateGudangDanTokoRequest;
use App\Models\GudangDanToko;
use Illuminate\Support\Facades\DB;

class GudangDanTokoController extends Controller
{
    /**
     * Display a listing of the gudang.
     */
    public function index()
    {
        $gudangs = GudangDanToko::orderBy('id')->paginate(10);
        return view('gudangs_dan_tokos.index', compact('gudangs'));
    }

    /**
     * Show the form for creating a new gudang.
     */
    public function create()
    {
        return view('gudangs_dan_tokos.create');
    }

    /**
     * Store a newly created gudang in storage.
     */
    public function store(StoreGudangDanTokoRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                GudangDanToko::create($request->validated());
            });

            return redirect()->route('gudangs_dan_tokos.index')->with('success', 'Gudang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan gudang: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified gudang.
     */
    public function show(GudangDanToko $gudangDanToko)
    {
        return view('gudangs_dan_tokos.show', compact('gudang'));
    }

    /**
     * Show the form for editing the specified gudang.
     */
    public function edit(GudangDanToko $gudangDanToko)
    {
        return view('gudangs_dan_tokos.edit', compact('gudang'));
    }

    /**
     * Update the specified gudang in storage.
     */
    public function update(UpdateGudangDanTokoRequest $request, GudangDanToko $gudangDanToko)
    {
        try {
            DB::transaction(function () use ($request, $gudangDanToko) {
                $gudangDanToko->update($request->validated());
            });

            return redirect()->route('gudangs_dan_tokos.index')->with('success', "{$gudangDanToko->nama_gudang_toko} berhasil diperbarui.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => "Gagal memperbarui {$gudangDanToko->nama_gudang_toko}: {$e->getMessage()}"]);
        }
    }

    /**
     * Deactivate the specified gudang from storage.
     */
    public function deactivate(GudangDanToko $gudangDanToko)
    {
        if ($gudangDanToko->flag != 1) {
            return redirect()->route('gudangs_dan_tokos.index')
                ->with('error', 'Tidak ditemukan gudang atau toko.');
        }

        try {
            DB::transaction(function () use ($gudangDanToko) {
                $gudangDanToko->update(['flag' => 0]);
                $gudangDanToko->users()->update(['flag' => 0]);
            });

            return redirect()->back()->with('success', "{$gudangDanToko->nama_gudang} berhasil dinonaktifkan.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => "Gagal menonaktifkan {$gudangDanToko->nama_gudang}: {$e->getMessage()}"]);
        }
    }

    /**
     * Activate the specified gudang from storage.
     */
    public function activate(GudangDanToko $gudangDanToko)
    {
        if ($gudangDanToko->flag != 0) {
            return redirect()->route('gudangs_dan_tokos.index')
                ->with('error', 'Tidak ditemukan gudang atau toko.');
        }

        try {
            DB::transaction(function () use ($gudangDanToko) {
                $gudangDanToko->update(['flag' => 1]);
                $gudangDanToko->users()->update(['flag' => 1]);
            });

            return redirect()->back()->with('success', "$gudangDanToko->nama_gudang} berhasil diaktifkan.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => "Gagal mengaktifkan {$gudangDanToko->nama_gudang}: {$e->getMessage()}"]);
        }
    }
}