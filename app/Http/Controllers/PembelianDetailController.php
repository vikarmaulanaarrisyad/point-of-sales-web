<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelianDetailController extends Controller
{
    public function data($id)
    {
        $query = PembelianDetail::with(['produk', 'pembelian'])->where('pembelian_id', $id)->get();

        $data = [];
        $total = 0;
        $total_item = 0;

        foreach ($query as $item) {
            $row = [];
            $row['barcode'] = '<span class="badge badge-info">' . $item->produk->barcode . '</span>';
            $row['nama_produk'] = $item->produk->nama_produk;
            $row['harga_beli'] = format_uang($item->produk->harga_beli);
            $row['quantity'] = '<input type="number" name="quantity" class="form-control input-sm quantity" data-id="' . $item->id . '" min="1" value="' . $item->jumlah . '">';

            $row['subtotal'] = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi'] = '
            <button class="btn btn-sm btn-danger" onclick="deleteData(`' . route('pembeliandetail.destroy', $item->id) . '`,`' . $item->produk->nama_produk . '`)"><i class="fas fa-trash"></i></button>
        ';

            $data[] = $row;

            $total += $item->produk->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'barcode' => '',
            'nama_produk' => '
            <div class="total hide">' . $total . '</div>
            <div class="total_item hide">' . $total_item . '</div>
        ',
            'harga_beli' => '',
            'quantity' => '',
            'subtotal' => '',
            'aksi' => '',
        ];

        return datatables($data)
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelian = Pembelian::where('status', 'pending')->first();
        $memberSelected = Pelanggan::where('id', $pembelian->pelanggan_id)->first();
        return view('transaksi.pembelian_detail.index', compact('pembelian', 'memberSelected'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $produk = Product::where('id', $request->product_id)->first();

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Cek apakah ada pembelian dengan status "pending"
        $pembelian = Pembelian::where('id', $request->pembelian_id)->where('status', 'pending')->first();

        if (!$pembelian) {
            return response()->json(['message' => 'Pembelian dengan status pending tidak ditemukan'], 404);
        }

        // Cek apakah produk sudah ada di detail pembelian
        $detail = PembelianDetail::where('pembelian_id', $pembelian->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($detail) {
            // Jika produk sudah ada, tambahkan jumlahnya dan perbarui subtotal
            $detail->jumlah += 1;
            $detail->subtotal = $detail->jumlah * $detail->harga_beli;
            $detail->save();

            return response()->json(['message' => 'Jumlah produk berhasil diperbarui'], 200);
        } else {
            // Jika produk belum ada, tambahkan produk baru ke keranjang
            $detail = new PembelianDetail();
            $detail->pembelian_id = $pembelian->id;
            $detail->product_id = $request->product_id;
            $detail->jumlah = 1;
            $detail->harga_beli = $produk->harga_beli;
            $detail->subtotal = $detail->harga_beli;
            $detail->save();

            return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang'], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PembelianDetail $pembelianDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PembelianDetail $pembelianDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $detail = PembelianDetail::findOrFail($id);
        $stok = $detail->produk->stok;
        // if ($stok < $request->quantity) {
        //     return response()->json(['message' => 'Jumlah melebihi stok maksimal ' . $stok], 422);
        // }

        $detail->jumlah = $request->quantity;
        $detail->subtotal = $detail->produk->harga_beli * $request->quantity;
        $detail->update();

        return response()->json(['message' => 'Detail penjualan berhasil diperbarui'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Hapus detail pembelian
            $pembelianDetail = PembelianDetail::find($id);
            $pembelianDetail->delete();

            return response()->json(['message' => 'Item berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus item', 'error' => $e->getMessage()], 500);
        }
    }

    public function produk()
    {
        $query = Product::with('category')->get();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('harga_beli', function ($query) {
                return format_uang($query->harga_beli);
            })
            ->addColumn('aksi', function ($query) {
                $stok = $query->stok;
                return '
                    <button type="button" class="btn btn-sm btn-danger" onclick="pilihProduk(`' . $query->id . '`,`' . $query->nama_produk . '`)"><i class="fas fa-check-circle"></i> Pilih</button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function loadForm($total, $diterima)
    {
        $bayar = $total;
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data  = [
            'diterima' => $diterima,
            'totalrp' => format_uang($total),
            'bayar'   => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali) . ' Rupiah'),
        ];

        return response()->json($data);
    }
}
