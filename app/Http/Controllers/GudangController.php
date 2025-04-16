<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::where('flag', 1)->orderBy('id')->paginate(10);
        return view('gudangs.index', compact('gudangs'));
    }

    public function create()
    {
        return view('gudangs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_gudang' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Gudang::create([
                    'nama_gudang' => $request->nama_gudang,
                    'lokasi' => $request->lokasi,
                    'flag' => 1, // Set flag ke 1 saat membuat gudang baru
                ]);
            });

            return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan gudang: ' . $e->getMessage()]);
        }
    }

    public function show(Gudang $gudang)
    {
        return view('gudangs.show', compact('gudang'));
    }

    public function edit(Gudang $gudang)
    {
        return view('gudangs.edit', compact('gudang'));
    }

    public function update(Request $request, Gudang $gudang)
    {
        $request->validate([
            'nama_gudang' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $gudang) {
                $gudang->update([
                    'nama_gudang' => $request->nama_gudang,
                    'lokasi' => $request->lokasi,
                ]);
            });

            return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui gudang: ' . $e->getMessage()]);
        }
    }

    public function destroy(Gudang $gudang)
    {
        try {
            DB::transaction(function () use ($gudang) {
                $gudang->delete();
            });

            return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus gudang: ' . $e->getMessage()]);
        }
    }
}