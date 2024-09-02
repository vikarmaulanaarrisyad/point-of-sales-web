<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function data()
    {
        $query = Pembelian::orderBy('id', 'DESC');
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($q) {
                return date('d-m-Y', strtotime($q->created_at));
            })
            ->addColumn('supplier', function ($q) {
                return $q->supplier->nama_toko ?? 'Tidak ada supplier';
            })
            ->addColumn('total_harga', function ($q) {
                return format_uang($q->total_harga);
            })
            ->addColumn('bayar', function ($q) {
                return format_uang($q->bayar);
            })
            ->addColumn('aksi', function ($query) {
                return '
            <div class="btn-group">
                <button onclick="showDetail(`' . route('pembelian.show', $query->id) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                <button onclick="deleteData(`' . route('pembelian.destroy', $query->id) . '`,`' . $query->kode_penjualan . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            </div>
            ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelianPending = Pembelian::where('status', 'pending')->first();
        return view('transaksi.pembelian.index', compact('pembelianPending'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pembelian = Pembelian::where('status', 'pending')->first();

        if ($pembelian) {
            $memberSelected = Pelanggan::where('id', $pembelian->supplier_id)->first();
            return redirect()->route('pembeliandetail.index', compact('pembelian', 'memberSelected'))->with(['error' => true, 'message' => 'Transaksi pembelian sedang berlangsung']);
        }

        $pembelian = new Pembelian();
        $pembelian->supplier_id = 0;
        $pembelian->total_item = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon = 0;
        $pembelian->bayar = 0;
        $pembelian->save();

        return redirect()->route('pembeliandetail.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pembelian = Pembelian::findOrfail($request->pembelian_id);
        $pembelian->supplier_id = $request->pelanggan;
        $pembelian->total_item = $request->total_item;
        $pembelian->total_harga = $request->total;
        $pembelian->bayar = $request->bayar;
        $pembelian->status = 'paid';
        $pembelian->update();

        $pembelianDetail = PembelianDetail::where('pembelian_id', $request->pembelian_id)->get();
        foreach ($pembelianDetail as $item) {
            $product = Product::findOrfail($item->product_id);
            $product->stok += $item->jumlah;
            $product->update();
        }

        return redirect()->route('pembelian.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembelian $pembelian)
    {
        $query = PembelianDetail::with(['produk'])->where('pembelian_id', $pembelian->id)->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('nama_produk', function ($query) {
                return $query->produk->nama_produk;
            })
            ->addColumn('harga', function ($query) {
                return format_uang($query->produk->harga_jual);
            })
            ->addColumn('jumlah', function ($query) {
                return format_uang($query->jumlah);
            })
            ->addColumn('subtotal', function ($query) {
                return 'Rp. ' . format_uang($query->subtotal);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        $detail = PembelianDetail::where('pembelian_id', $pembelian->id)->get();

        foreach ($detail as $item) {
            $product = Product::findOrfail($item->product_id);
            if ($product) {
                $product->stok += $item->quantity;
                $product->update();
            }

            $item->delete();
        }

        $pembelian->delete();

        return response()->json(['message' => 'Data Berhasil Dihapus', 'data' => null]);
    }
}
