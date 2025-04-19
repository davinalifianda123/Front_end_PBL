<?php

namespace App\Http\Controllers;

use App\Http\Requests\Toko\StoreTokoRequest;
use App\Http\Requests\Toko\UpdateTokoRequest;
use App\Models\Toko;
use App\Models\JenisToko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokoController extends Controller
{
    /**
     * Display a listing of the toko.
     */
    public function index()
    {
        $tokos = Toko::with('jenisToko')->paginate(10);
        return view('tokos.index', compact('tokos'));
    }

    /**
     * Show the form for creating a new toko.
     */
    public function create()
    {
        $jenisTokos = JenisToko::all();
        return view('tokos.create', compact('jenisTokos'));
    }

    /**
     * Store a newly created toko in storage.
     */
    public function store(StoreTokoRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Toko::create($request->validated());
            });

            return redirect()->route('tokos.index')
                ->with('success', 'Toko berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified toko.
     */
    public function show(Toko $toko)
    {
        return view('tokos.show', compact('toko'));
    }

    /**
     * Show the form for editing the specified toko.
     */
    public function edit(Toko $toko)
    {   
        $jenisTokos = JenisToko::all();
        return view('tokos.edit', compact('toko', 'jenisTokos'));
    }

    /**
     * Update the specified toko in storage.
     */
    public function update(UpdateTokoRequest $request, Toko $toko)
    {
        try {
            DB::transaction(function () use ($request, $toko) {
                $toko->update($request->validated());
            });

            return redirect()->route('tokos.index')
                ->with('success', 'Toko berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Deactive the specified toko from storage.
     */
    public function deactivate(Toko $toko)
    {
        try {
            DB::transaction(function () use ($toko) {
                $toko->update(['flag' => 0]);
                $toko->user()->update(['flag' => 0]);
            });

            return redirect()->route('tokos.index')
                ->with('success', 'Toko berhasil dinonaktifkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menonaktifkan toko: ' . $e->getMessage());
        }
    }

    /**
     * Activate the specified toko from storage.
     */
    public function activate(Toko $toko)
    {
        try {
            DB::transaction(function () use ($toko) {
                $toko->update(['flag' => 1]);
                $toko->user()->update(['flag' => 1]);
            });

            return redirect()->route('tokos.index')
                ->with('success', 'Toko berhasil diaktifkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengaktifkan toko: ' . $e->getMessage());
        }
    }
}