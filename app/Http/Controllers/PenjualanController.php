<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawan = auth()->user()->karyawan->id ?? 2;

        $penjualan = new Penjualan();
        $penjualan->karyawan_id = $karyawan ?? 2;
        $penjualan->pelanggan_id = null;
        $penjualan->kode_penjualan = 'PJ-' . date('Ymd') . '-' . str_pad(Penjualan::count() + 1, 4, '0', STR_PAD_LEFT);
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->total_bayar = 0;
        $penjualan->total_kembalian = 0;
        $penjualan->bukti_bayar = null;
        $penjualan->catatan = null;
        $penjualan->status_bayar = 'pending';
        $penjualan->save();

        session(['penjualan_id' => $penjualan->id]);

        return redirect()->route('transaksi.index');
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
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
}
