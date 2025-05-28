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
        $token = 'eyJpdiI6Ill2WlNFczBKVzdXcXFFQVBGNWJNbWc9PSIsInZhbHVlIjoiMERBTDd2bjZXUFg5RUR4WW84M04raW5UbEg3UEZRQVR3bHR4UUZrZmF1TkhvOSt5RUZEVlc1aFgvRk5kOHJIN20rc0R4bnBzRGxHZFA2ZUxJZm41WGtrckxnTlRyT2V0anVDQXAvNG55MDJWVDFZek5ZOTl0Q2FLME9RR0ptM2dkbUhoSE1ZNjdrZWVVejdIbnhuUi9zcEh5cEpCbUFpWTB6eVlwRmUvRE9nWjErSEhHV0hYcHYzanhXMzNRSDI3WG9RamRHencwTm8zZHNUcW9YdytMTmxWOGdqMzF2N3hBUWd1RW9OT3Fqclk4RUJGMmY4YkExTlJzakIzekVraWhiMmVZcEc4RVhvZGdIa3EwdWdSMGR5NEptb3VYS2tSYldVVjBuMTNOUUJ5U252LzJhR3R3SUVVbSsxRFNUcjhwR1lUclZLRlY5NnFUVXhwWnIvM2VQNUlpcnNzaXlENHNrWFBleWxBNHpUcjFiejFmVFBEQWdqbnJiNzdOOE5CU3J4bEEvQ3JjMllSdk9KdzFCR1VqUkpMbFA1cTdrK1RZZ0pPZmN2aitrSFQ0eE5MZ2FtNDRVZVUwb2pkUnp2Z29rdDZpUmZ0aEdRK294RCttWHpiajE1dmlRb3Npd3BDVXRLaDlWajV4ajNRVjRTdzlITnNlSzRwN1VjWW9oaUdzTW9vM0hScnErZkNwempndzl3SlRRPT0iLCJtYWMiOiI3MWM4MjE3MGNhOWMxMzliM2NjZTViOGFmYTBkNzI0YWViMWUwZDUwMzMyNTM5ZjI3YWNlYWU5NjdiZDE4N2NmIiwidGFnIjoiIn0%3D';
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