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

        // cek apakah ada transaksi yang sedang berjalan
        if (!$penjualan) {
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('transaksi.index');
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            $memberSelected = $penjualan->pelanggan ?? new Pelanggan();
            return view('transaksi.penjualan_detail.index', compact('pelanggan', 'produk', 'memberSelected', 'penjualan'));
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
            $row['harga_jual'] =  format_uang($item->produk['harga_jual']);
            $row['quantity']      = '<input type="number" name="quantity" class="form-control input-sm quantity" data-id="' . $item->id . '"  min="1" value="' . $item->quantity . '"">';

            $row['subtotal']    = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi']        = '
                                    <button class="btn btn-sm btn-danger" onclick="deleteData(`' . route('transaksi.destroy', $item->id) . '`,`' . $item->produk->nama_produk . '`)"><i class="fas fa-trash"></i></button>
                                ';

            $data[] = $row;

            $total += $item->price * $item->quantity;
            $total_item += $item->quantity;
        }

        $data[] = [
            'barcode' => '',
            'nama_produk' => '
                <div class="total hide">' . $total . '</div>
                <div class="total_item hide">' . $total_item . '</div>
            ',
            'harga_jual' => '',
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $produk = Product::where('id', $request->product_id)->first();

        if (!$produk) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 422);
        }

        // Cek apakah product_id sudah ada di tabel penjualan_details
        $existingDetail = PenjualanDetail::where('product_id', $request->product_id)
            ->where('penjualan_id', $request->penjualan_id)
            ->first();

        if ($existingDetail) {
            // Tambah quantity dan update subtotal
            $existingDetail->quantity += 1;
            $existingDetail->subtotal = $existingDetail->quantity * $produk->harga_jual;
            $existingDetail->save();

            return response()->json(['message' => 'Quantity produk berhasil ditambah'], 200);
        }

        // Jika produk belum ada di detail, buat detail baru
        $detail = new PenjualanDetail();
        $detail->penjualan_id = $request->penjualan_id;
        $detail->product_id = $request->product_id;
        $detail->quantity = 1;
        $detail->price = $produk->harga_jual;
        $detail->subtotal = $produk->harga_jual;
        $detail->save();

        return response()->json(['message' => 'Transaksi penjualan berhasil disimpan'], 200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $detail = PenjualanDetail::findOrFail($id);
        $stok = $detail->produk->stok;
        if ($stok < $request->quantity) {
            return response()->json(['message' => 'Jumlah melebihi stok maksimal ' . $stok], 422);
        }
        $detail->quantity = $request->quantity;
        $detail->subtotal = $detail->produk->harga_jual * $request->quantity;
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();

        return response()->json(['message' => 'Transaksi penjualan berhasil dihapus'], 200);
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
                    <button type="button" class="btn btn-sm btn-danger" onclick="pilihPelanggan(`' . $query->id . '`,`' . $query->nama_toko . '`)"><i class="fas fa-check-circle"></i> Pilih</button>
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
