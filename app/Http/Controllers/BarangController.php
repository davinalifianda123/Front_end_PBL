<?php
namespace App\Http\Controllers;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\KategoriBarang;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Barang\StoreBarangRequest;
use App\Http\Requests\Barang\UpdateBarangRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BarangController extends Controller
{
    /**
     * Display a listing of the product.
     */
    public function index()
    {
        try {
            $barangs = Barang::with(['kategori'])->orderBy('id')->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Data Barang',
                'data' => $barangs,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data Barang.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        try {
            $categories = KategoriBarang::all();

            return response()->json([
                'status' => true,
                'message' => 'Data untuk Form Tambah Barang',
                'data' => [
                    'categories' => $categories,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data untuk form tambah Barang.',
                'error' => $e->getMessage(), 
            ], 500);
        }
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nama_barang' => [
                    'required',
                    'unique:barangs',
                    'string',
                    'max:255',
                ],
                'id_kategori_barang' => [
                    'required',
                    'exists:kategori_barangs,id',
                ],
            ]);

            DB::transaction(function () use ($validated) {
                Barang::create($validated);
            }, 3);

            return response()->json([
                'status' => true,
                'message' => "Barang {$request->input('nama_barang')} berhasil ditambahkan!",
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
                'message' => 'Terjadi kesalahan saat menyimpan barang.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => "Detail Data Barang dengan ID: {$id}",
                'data' => $barang,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "Data Barang dengan ID: {$id} tidak ditemukan.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Terjadi kesalahan saat mengambil detail data Barang dengan ID: {$id}",
                'error' => $e->getMessage(), // Hanya tampilkan detail error saat development
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified product.
     */

    public function edit(string $id)
    {
        try {
            $barang = Barang::with('kategori')->findOrFail($id);
            $kategoris = KategoriBarang::all();

            return response()->json([
                'status' => true,
                'message' => 'Data untuk Form Edit Barang',
                'data' => [
                    'barang' => $barang,
                    'kategoris' => $kategoris,
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "Data Barang dengan ID: {$id} tidak ditemukan.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengambil data untuk form edit Barang.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $barang = Barang::findOrFail($id);

            $rules = [
                'nama_barang' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'id_kategori_barang' => [
                    'nullable',
                    'exists:kategori_barangs,id',
                ],
            ];

            if ($request->input('nama_barang') !== $barang->nama_barang) {
                $rules['nama_barang'][] = 'unique:barangs';
            }

            $validated = $request->validate($rules);

            DB::transaction(function () use ($validated, $barang) {
                $barang->update($validated);
            }, 3);

            return response()->json([
                'status' => true,
                'message' => "Barang {$barang->nama_barang} berhasil diperbarui!",
                'data' => $barang,
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
                'message' => "Data Barang dengan ID: {$id} tidak ditemukan.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Terjadi kesalahan saat memperbarui barang dengan ID {$id}.",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Deactivate the specified product from storage.
     */
    public function deactivate(string $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            DB::transaction(function () use ($barang) {
                $barang->update(['flag' => 0]);
            }, 3);

            return view('barangs.index', [
                'status' => true,
                'message' => "Barang {$barang->nama_barang} berhasil dinonaktifkan!",
                'data' => $barang,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "Data Barang dengan ID: {$id} tidak ditemukan.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Terjadi kesalahan saat menonaktifkan barang dengan ID {$id}.",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Activate the specified product from storage.
     */
    public function activate(string $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            DB::transaction(function () use ($barang) {
                $barang->update(['flag' => 1]);
            }, 3);

            return view('barangs.index' , [
                'status' => true,
                'message' => "Barang {$barang->nama_barang} berhasil diaktifkan!",
                'data' => $barang,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "Data Barang dengan ID: {$id} tidak ditemukan.",
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Terjadi kesalahan saat mengaktifkan barang dengan ID {$id}.",
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}