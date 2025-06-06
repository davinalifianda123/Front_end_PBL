<?php

namespace App\Http\Controllers;

use App\Models\GudangDanToko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SupplierController extends Controller
{
    public function index()
    {
       try {
            $suppliers = GudangDanToko::where('kategori_bangunan', 1)
                ->orderBy('id')
                ->paginate(10);

            return view('suppliers.index', compact('suppliers'));
        } catch (\Exception $e) {
            return view('suppliers.index', ['message' => 'Terjadi kesalahan saat mengambil data Kategori Barang.', 'error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            return view('suppliers.create', [
                'message' => 'Form Tambah Supplier',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyiapkan form tambah supplier.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
       try {
            $supplier = GudangDanToko::where('kategori_bangunan', 1)->findOrFail($id);
            return view('suppliers.show', [
                'supplier' => $supplier,
                'message' => "Data Supplier dengan ID: {$id}",
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "Data Supplier dengan ID: {$id} tidak ditemukan.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Terjadi kesalahan saat mengambil detail data Supplier dengan ID: {$id}.",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_gudang_toko' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'alamat' => 'nullable|string',
                'no_telepon' => 'nullable|string|max:20',
            ]);

            $supplier = GudangDanToko::create(array_merge($validated, ['kategori_bangunan' => 1]));

            return view('suppliers.index', [
                'status' => true,
                'message' => "Supplier {$supplier->nama_gudang_toko} berhasil ditambahkan!",
                'data' => $supplier,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data yang diberikan tidak valid.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan supplier.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(string $id)
    {
        try {
            $supplier = GudangDanToko::where('kategori_bangunan', 1)->findOrFail($id);

            return view('suppliers.edit', [
                'supplier' => $supplier,
                'message' => "Data Supplier dengan ID: {$id}",
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "Data Supplier dengan ID: {$id} tidak ditemukan.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data untuk form edit Supplier.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $supplier = GudangDanToko::where('kategori_bangunan', 1)->findOrFail($id);

            $validated = $request->validate([
                'nama_gudang_toko' => 'required|string|max:255',
                'alamat' => 'nullable|string',
                'no_telepon' => 'nullable|string|max:20',
            ]);

            $supplier->update($validated);

            return view('suppliers.index', [
                'status' => true,
                'message' => "Supplier {$supplier->nama_gudang_toko} berhasil diperbarui!",
                'data' => $supplier,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data yang diberikan tidak valid.',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "Data Supplier dengan ID: {$id} tidak ditemukan.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Terjadi kesalahan saat memperbarui supplier dengan ID {$id}.",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deactivate(string $id)
    {
        try {
            $supplier = GudangDanToko::where('kategori_bangunan', 1)->findOrFail($id);

            $supplier->update(['flag' => 0]);

            return view('suppliers.index', [
                'status' => true,
                'message' => "Supplier {$supplier->nama_gudang_toko} berhasil dinonaktifkan!",
                'data' => $supplier,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "Data Supplier dengan ID: {$id} tidak ditemukan.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Terjadi kesalahan saat menonaktifkan supplier dengan ID {$id}.",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        // Logic to delete a supplier
    }
}
