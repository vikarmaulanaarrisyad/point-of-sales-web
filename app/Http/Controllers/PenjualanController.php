<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaksi.penjualan.index');
    }

    public function data()
    {
        $query = Penjualan::with('pelanggan')->orderBy('id', 'desc');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($query) {
                return tanggal_indonesia($query->created_at);
            })
            ->editColumn('kode_penjualan', function ($query) {
                return '<span class="badge badge-success">' . $query->kode_penjualan . '</span>';
            })
            ->editColumn('total_bayar', function ($query) {
                return format_uang($query->total_bayar);
            })
            ->editColumn('total_harga', function ($query) {
                return format_uang($query->total_harga);
            })
            ->addColumn('aksi', function ($query) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`' . route('penjualan.show', $query->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`' . route('penjualan.destroy', $query->id) . '`,`' . $query->kode_penjualan . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawan = auth()->user()->karyawan->id ?? 1;

        $penjualan = new Penjualan();
        $penjualan->karyawan_id = $karyawan ?? 1;
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

        return redirect()->route('transaksi.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $penjualan = Penjualan::findOrfail($request->penjualan_id);
        $penjualan->pelanggan_id = $request->pelanggan;
        $penjualan->total_item = $request->total_item;
        $penjualan->total_harga = $request->total;
        $penjualan->total_bayar = $request->bayar;
        $penjualan->total_kembalian = $request->total - $request->bayar;
        $penjualan->status_bayar = 'success';
        $penjualan->update();

        $penjualanDetail = PenjualanDetail::where('penjualan_id', $request->penjualan_id)->get();
        foreach ($penjualanDetail as $item) {
            $product = Product::findOrfail($item->product_id);
            $product->stok -= $item->quantity;
            $product->update();
        }

        return redirect()->route('penjualan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        $query = PenjualanDetail::with(['produk'])->where('penjualan_id', $penjualan->id)->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('nama_produk', function ($query) {
                return $query->produk->nama_produk;
            })
            ->addColumn('harga', function ($query) {
                return format_uang($query->produk->harga_jual);
            })
            ->addColumn('jumlah', function ($query) {
                return format_uang($query->quantity);
            })
            ->addColumn('subtotal', function ($query) {
                return 'Rp. ' . format_uang($query->subtotal);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        $detail     = PenjualanDetail::where('penjualan_id', $penjualan->id)->get();

        foreach ($detail as $item) {
            $product = Product::findOrfail($item->product_id);
            if ($product) {
                $product->stok += $item->quantity;
                $product->update();
            }

            $item->delete();
        }

        $penjualan->delete();

        return response()->json(['message' => 'Data Berhasil Dihapus', 'data' => null]);
    }
}
