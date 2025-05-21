<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GudangDanToko;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TokoController extends Controller
{
    public function index()
    {
        try {
            $tokos = GudangDanToko::where('kategori_bangunan', 1)
                ->orderBy('id')
                ->paginate(10);

            return view('tokos.index', compact('tokos'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengambil data toko: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('tokos.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_gudang_toko' => 'required|string|max:255',
                'alamat' => 'nullable|string',
                'no_telepon' => 'nullable|string|max:20',
            ]);

            $toko = GudangDanToko::create(array_merge($validated, ['kategori_bangunan' => 1]));

            return redirect()->route('toko.index')->with('success', "Toko {$toko->nama_gudang_toko} berhasil ditambahkan.");
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan toko.');
        }
    }

    public function show($id)
    {
        try {
            $toko = GudangDanToko::where('kategori_bangunan', 1)->findOrFail($id);
            return view('tokos.show', compact('toko'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Data Toko dengan ID: {$id} tidak ditemukan.");
        }
    }

    public function edit($id)
    {
        try {
            $toko = GudangDanToko::where('kategori_bangunan', 1)->findOrFail($id);
            return view('tokos.edit', compact('toko'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Data Toko dengan ID: {$id} tidak ditemukan.");
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

            $toko = GudangDanToko::where('kategori_bangunan', 1)->findOrFail($id);
            $toko->update($validated);

            return redirect()->route('toko.index')->with('success', "Toko {$toko->nama_gudang_toko} berhasil diperbarui.");
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Data Toko dengan ID: {$id} tidak ditemukan.");
        }
    }

    public function deactivate($id)
    {
        try {
            $toko = GudangDanToko::where('kategori_bangunan', 1)->findOrFail($id);
            $toko->update(['flag' => 0]);

            return redirect()->route('toko.index')->with('success', "Toko {$toko->nama_gudang_toko} berhasil dinonaktifkan.");
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Data Toko tidak ditemukan.");
        }
    }

    public function activate($id)
    {
        try {
            $toko = GudangDanToko::where('kategori_bangunan', 1)->findOrFail($id);
            $toko->update(['flag' => 1]);

            return redirect()->route('toko.index')->with('success', "Toko {$toko->nama_gudang_toko} berhasil diaktifkan.");
        } catch (ModelNotFoundException $e) {
            return back()->with('error', "Data Toko tidak ditemukan.");
        }
    }
}
