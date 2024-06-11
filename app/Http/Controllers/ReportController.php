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

        if ($request->has('start') && $request->start != "" && $request->has('end') && $request->end != "") {
            $start = $request->start;
            $end = $request->end;
        }

        return view('report.index', compact('start', 'end'));
    }

    public function data(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $query = PenjualanDetail::with('produk', 'penjualan')
            ->whereBetween('tanggal', [$start, $end])
            ->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($query) {
                return tanggal_indonesia($query->tanggal);
            })
            ->addColumn('product', function ($query) {
                return $query->produk->nama_produk;
            })
            ->addColumn('stock', function ($query) {
                return $query->produk->stok;
            })
            ->addColumn('harga_pabrik', function ($query) {
                return format_uang($query->produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($query) {
                return format_uang($query->produk->harga_jual);
            })
            ->addColumn('profit', function ($query) {
                // return ($query->subtotal - $query->produk->harga_jual) * $query->quantity;
                return format_uang($query->produk->stok * ($query->produk->harga_jual - $query->produk->harga_beli));
            })
            ->rawColumns(['tanggal', 'product', 'stock', 'harga_pabrik', 'harga_jual', 'profit'])
            ->make(true);
    }
}
