<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use App\Models\Product;
use Carbon\Carbon;
use Dompdf\Dompdf;

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
        $start = Carbon::parse($request->start)->format('Y-m-d');
        $end = Carbon::parse($request->end)->format('Y-m-d');

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

    public function exportPDF1(Request $request)
    {
        // Ambil data dari periode yang dipilih
        $start = Carbon::parse($request->start)->format('Y-m-d');
        $end = Carbon::parse($request->end)->format('Y-m-d');

        $data = PenjualanDetail::with('produk', 'penjualan')
            ->whereBetween('tanggal', [$start, $end])
            ->get();

        // Render HTML untuk view PDF
        $html = view('report.pdf', compact('data'))->render();

        // Inisialisasi Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Setup ukuran dan orientasi kertas
        $dompdf->setPaper('A4', 'landscape');

        // Render HTML menjadi PDF
        $dompdf->render();

        // Hasilkan PDF ke browser tanpa mendownloadnya
        return $dompdf->stream('laporan-penjualan.pdf', ["Attachment" => false]);
    }

    public function exportPDF(Request $request)
    {
        // Ambil data dari periode yang dipilih
        $start = Carbon::parse($request->start)->format('Y-m-d');
        $end = Carbon::parse($request->end)->format('Y-m-d');

        // Hitung stok awal
        $stokAwal = Product::with(['pembelian', 'penjualan'])
            ->selectRaw('SUM(pembelian.quantity) - SUM(penjualan.quantity) as stok_awal')
            ->where('tanggal', '<', $start)
            ->first()
            ->stok_awal;

        // Hitung stok masuk dan keluar selama periode
        $stokMasuk = Product::with('pembelian')
            ->selectRaw('SUM(pembelian.quantity) as total_masuk')
            ->whereBetween('tanggal', [$start, $end])
            ->first()
            ->total_masuk;

        $stokKeluar = Product::with('penjualan')
            ->selectRaw('SUM(penjualan.quantity) as total_keluar')
            ->whereBetween('tanggal', [$start, $end])
            ->first()
            ->total_keluar;

        // Hitung stok akhir
        $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar;

        // Ambil data penjualan selama periode
        $data = PenjualanDetail::with('produk', 'penjualan')
            ->whereBetween('tanggal', [$start, $end])
            ->get();

        // Render HTML untuk view PDF
        $html = view('report.pdf', compact('data', 'stokAwal', 'stokAkhir'))->render();

        // Inisialisasi Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Setup ukuran dan orientasi kertas
        $dompdf->setPaper('A4', 'landscape');

        // Render HTML menjadi PDF
        $dompdf->render();

        // Hasilkan PDF ke browser tanpa mendownloadnya
        return $dompdf->stream('laporan-penjualan.pdf', ["Attachment" => false]);
    }
}
