<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanDetail;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = now()->subDay(30)->format('Y-m-d');
        $end = now()->format('Y-m-d');

        if ($request->has('start') && $request->has('end')) {
            $start = $request->start;
            $end = $request->end;
        }

        return view('report.index', compact('start', 'end'));
    }

    public function data(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $details = PenjualanDetail::with('produk', 'penjualan')
            ->whereHas('penjualan', function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            })
            ->get();

        return datatables()->of($details)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($detail) {
                return tanggal_indonesia($detail->penjualan->created_at, false, true);
            })
            ->addColumn('product', function ($detail) {
                return $detail->produk->nama_produk;
            })
            ->addColumn('stock', function ($detail) {
                return $detail->produk->stok;
            })
            ->addColumn('harga_pabrik', function ($detail) {
                return $detail->produk->harga_beli;
            })
            ->addColumn('harga_jual', function ($detail) {
                return $detail->produk->harga_jual;
            })
            ->addColumn('profit', function ($detail) {
                return ($detail->subtotal - $detail->produk->harga_jual) * $detail->quantity;
            })
            ->rawColumns(['tanggal', 'product', 'stock', 'harga_pabrik', 'harga_jual', 'profit'])
            ->make(true);
    }
}
