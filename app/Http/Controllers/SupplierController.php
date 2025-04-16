<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::where('flag', 1)->get();
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_toko_supplier' => 'required|max:255',
            'alamat' => 'required',
            'no_telepon' => 'required|max:15',
            'email' => 'required|email|max:255',
            'contact_person' => 'required|max:255',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                Supplier::create($validatedData);
            });
            
            return redirect()->route('suppliers.index')
                ->with('success', 'Supplier berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validatedData = $request->validate([
            'nama_toko_supplier' => 'required|max:255',
            'alamat' => 'required',
            'no_telepon' => 'required|max:15',
            'email' => 'required|email|max:255',
            'contact_person' => 'required|max:255',
        ]);

        try {
            DB::transaction(function () use ($supplier, $validatedData) {
                $supplier->update($validatedData);
            });
            
            return redirect()->route('suppliers.index')
                ->with('success', 'Data supplier berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            DB::transaction(function () use ($supplier) {
                // Soft delete dengan mengubah flag menjadi 0
                $supplier->update(['flag' => 0]);
            });
            
            return redirect()->route('suppliers.index')
                ->with('success', 'Supplier berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}