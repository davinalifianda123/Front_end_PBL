<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;use App\Models\Barang;
use App\Models\GudangDanToko;
use App\Models\KategoriBarang;
use App\Models\SupplierKePusat;
use App\Models\TokoKeCabang;
class DashboardController extends Controller
{
    public function index()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDEvYXBpL2xvZ2luIiwiaWF0IjoxNzQ3OTcxMjE2LCJleHAiOjE3NDc5OTI4MTYsIm5iZiI6MTc0Nzk3MTIxNiwianRpIjoieFA3MzZPNEY4QlNzQXpiQiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3Iiwicm9sZSI6IlN1cGVyQWRtaW4ifQ.Fqkrsh5X__6KgbSFc9zUg4p-RCz5p8CGJpBTvLLbPE4';
        $url = "http://localhost:8001/api/dashboard";
        $res = Http::withToken($token)->get($url);

        $dashboard = json_decode($res->body());
        $dashboard = $dashboard->data;

        return view('dashboard.index', compact('dashboard'));
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}