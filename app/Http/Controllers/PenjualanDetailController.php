<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $produk     = Product::orderBy('nama_produk')->get();
        $pelanggan  = Pelanggan::orderBy('nama_toko')->get();
        $penjualan  = Penjualan::orderBy('created_at', 'desc')
            ->where('karyawan_id', 1)->first();
        $stok   = PenjualanDetail::where('penjualan_id', $penjualan->id)
            ->whereHas('produk', function ($q) {
                return $q->where('stok', '>', 0);
            })->first();

        // cek apakah ada transaksi yang sedang berjalan
        if (!$penjualan) {
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('transaksi.index');
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            $memberSelected = $penjualan->pelanggan ?? new Pelanggan();
            return view('transaksi.penjualan_detail.index', compact('pelanggan', 'produk', 'memberSelected', 'penjualan', 'stok'));
        }
    }

    public function data($id)
    {
        $query = PenjualanDetail::where('penjualan_id', $id)->get();
        $data = [];
        $total = 0;
        $total_item = 0;

        foreach ($query as  $item) {
            $row = [];
            $row['barcode'] = '<span class="badge badge-info">' . $item->produk['barcode'] . '</span>';
            $row['nama_produk'] = $item->produk['nama_produk'];

            $row['harga_beli']  = 'Rp. ' . format_uang($item->produk->pembelianDetail);
            $row['harga_jual']  = '<input id="harga_jual" onkeyup="format_uang(this)" type="text" name="harga_jual" data-id="' . $item->id . '"  class="form-control input-sm harga_jual" value="' . format_uang($item->harga_jual) . '">';
            $row['jumlah']      = '<input type="number" name="jumlah" class="form-control input-sm quantity" data-id="' . $item->id . '"  min="1" value="' . $item->jumlah . '"">';

            $row['subtotal']    = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi']        = '
                                    <button class="btn btn-sm btn-danger" onclick="deleteData(`' . route('transaksi.destroy', $item->id) . '`,`' . $item->produk->nama_produk . '`)"><i class="fas fa-trash"></i></button>
                                ';

            $data[] = $row;

            $total += $item->harga_jual * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'barcode' => '',
            'nama_produk' => '
                <div class="total hide">' . $total . '</div>
                <div class="total_item hide">' . $total_item . '</div>
            ',
            'harga_jual' => '',
            'jumlah' => '',
            'subtotal' => '',
            'aksi' => '',
        ];

        return datatables($data)
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // buat session baru
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $produk = Product::where('id', $request->produk_id)->first();
        if (!$produk) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 422);
        }

        $detail = new PenjualanDetail();
        $detail->penjualan_id   = $request->penjualan_id;
        $detail->produk_id      = $request->produk_id;
        $detail->harga_awal     = $produk->harga_jual;
        $detail->harga_jual     = $produk->harga_jual;
        $detail->quantity         = 1;
        $detail->price         = 0;
        $detail->subtotal       = $produk->harga_jual;
        $detail->save();

        return response()->json(['message' => 'Transaksi penjualan berhasil disimpan'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(PenjualanDetail $penjualanDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenjualanDetail $penjualanDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenjualanDetail $penjualanDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenjualanDetail $penjualanDetail)
    {
        //
    }

    public function produk()
    {
        $query = Product::with('category')->where('stok', '>', 1)->get();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('harga_beli', function ($query) {
                return format_uang($query->harga_beli);
            })
            ->addColumn('aksi', function ($query) {
                $stok = $query->stok;
                if ($stok > 1) {
                    return '
                    <button type="button" class="btn btn-sm btn-danger" onclick="pilihProduk(`' . $query->id . '`,`' . $query->nama_produk . '`)"><i class="fas fa-check-circle"></i> Pilih</button>
                ';
                } else {
                    return '
                    <button type="button" class="btn btn-sm btn-danger" disabled readonly><i class="fas fa-check-circle"></i> Pilih</button>
                ';
                }
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function pelanggan()
    {
        $query = Pelanggan::all();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('nama_toko', function ($query) {
                return '<span class="badge badge-info">' . $query->nama_toko . '</span>';
            })
            ->addColumn('aksi', function ($query) {
                return '
                    <button type="button" class="btn btn-sm btn-danger" onclick="pilihMember(`' . $query->id . '`,`' . $query->nama_toko . '`)"><i class="fas fa-check-circle"></i> Pilih</button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
