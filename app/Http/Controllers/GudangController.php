<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GudangDanToko;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GudangController extends Controller
{
    public function index()
    {
        try {
            $gudangs = GudangDanToko::where('kategori_bangunan', 0)
                ->orderBy('id')
                ->paginate(10);

            return view('gudangs.index', compact('gudangs'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengambil data gudang: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('gudangs.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_gudang_toko' => 'required|string|max:255',
                'alamat' => 'nullable|string',
                'no_telepon' => 'nullable|string|max:20',
            ]);

            $gudang = GudangDanToko::create(array_merge($validated, ['kategori_bangunan' => 0 ]));

            return redirect()->route('gudang.index')->with('success', "Gudang {$gudang->nama_gudang_toko} berhasil ditambahkan.");
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan gudang.');
        }
    }

    public function show($id)
    {
        try {
            $gudang = GudangDanToko::where('kategori_bangunan', 0)->findOrFail($id);
            return view('gudangs.show', compact('gudang'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Data Gudang dengan ID: {$id} tidak ditemukan.");
        }
    }

    public function edit($id)
    {
        try {
            $gudang = GudangDanToko::where('kategori_bangunan', 0)->findOrFail($id);
            return view('gudangs.edit', compact('gudang'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Data Gudang dengan ID: {$id} tidak ditemukan.");
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nama_gudang_toko' => 'required|string|max:255',
                'alamat' => 'nullable|string',
                'no_telepon' => 'nullable|string|max:20',
            ]);

            $gudang = GudangDanToko::where('kategori_bangunan', 0)->findOrFail($id);
            $gudang->update($validated);

            return redirect()->route('gudang.index')->with('success', "Gudang {$gudang->nama_gudang_toko} berhasil diperbarui.");
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Data Gudang dengan ID: {$id} tidak ditemukan.");
        }
    }

    public function deactivate($id)
    {
        try {
            $gudang = GudangDanToko::where('kategori_bangunan', 0)->findOrFail($id);
            $gudang->update(['flag' => 0]);

            return redirect()->route('gudang.index')->with('success', "Gudang {$gudang->nama_gudang_toko} berhasil dinonaktifkan.");
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Data Gudang tidak ditemukan.");
        }
    }

    public function activate($id)
    {
        try {
            $gudang = GudangDanToko::where('kategori_bangunan', 0)->findOrFail($id);
            $gudang->update(['flag' => 1]);

            return redirect()->route('gudang.index')->with('success', "Gudang {$gudang->nama_gudang_toko} berhasil diaktifkan.");
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Data Gudang tidak ditemukan.");
        }
    }
}
