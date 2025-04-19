<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gudang\StoreGudangRequest;
use App\Http\Requests\Gudang\UpdateGudangRequest;
use App\Models\Gudang;
use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
    /**
     * Display a listing of the gudang.
     */
    public function index()
    {
        $gudangs = Gudang::orderBy('id')->paginate(10);
        return view('gudangs.index', compact('gudangs'));
    }

    /**
     * Show the form for creating a new gudang.
     */
    public function create()
    {
        return view('gudangs.create');
    }

    /**
     * Store a newly created gudang in storage.
     */
    public function store(StoreGudangRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Gudang::create($request->validated());
            });

            return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan gudang: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified gudang.
     */
    public function show(Gudang $gudang)
    {
        return view('gudangs.show', compact('gudang'));
    }

    /**
     * Show the form for editing the specified gudang.
     */
    public function edit(Gudang $gudang)
    {
        return view('gudangs.edit', compact('gudang'));
    }

    /**
     * Update the specified gudang in storage.
     */
    public function update(UpdateGudangRequest $request, Gudang $gudang)
    {
        try {
            DB::transaction(function () use ($request, $gudang) {
                $gudang->update($request->validated());
            });

            return redirect()->route('gudangs.index')->with('success', "{$gudang->nama_gudang} berhasil diperbarui.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => "Gagal memperbarui {$gudang->nama_gudang}: {$e->getMessage()}"]);
        }
    }

    /**
     * Deactivate the specified gudang from storage.
     */
    public function deactivate(Gudang $gudang)
    {
        if ($gudang->flag != 1) {
            return redirect()->route('gudangs.index')
                ->with('error', 'Gudang tidak ditemukan.');
        }

        try {
            DB::transaction(function () use ($gudang) {
                $gudang->update(['flag' => 0]);
                $gudang->users()->update(['flag' => 0]);
            });

            return redirect()->back()->with('success', "{$gudang->nama_gudang} berhasil dinonaktifkan.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => "Gagal menonaktifkan {$gudang->nama_gudang}: {$e->getMessage()}"]);
        }
    }

    /**
     * Activate the specified gudang from storage.
     */
    public function activate(Gudang $gudang)
    {
        if ($gudang->flag != 0) {
            return redirect()->route('gudangs.index')
                ->with('error', 'Gudang tidak ditemukan.');
        }

        try {
            DB::transaction(function () use ($gudang) {
                $gudang->update(['flag' => 1]);
                $gudang->users()->update(['flag' => 1]);
            });

            return redirect()->back()->with('success', "Gudang {$gudang->nama_gudang} berhasil diaktifkan.");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => "Gagal mengaktifkan gudang {$gudang->nama_gudang}: {$e->getMessage()}"]);
        }
    }
}