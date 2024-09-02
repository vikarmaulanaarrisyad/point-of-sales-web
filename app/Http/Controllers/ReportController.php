<?php

namespace App\Http\Controllers;

use App\Models\PembelianDetail;
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

    public function exportPDF2(Request $request)
    {
        // Parsing tanggal
        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        // Hitung stok awal
        $stokAwal = PembelianDetail::where('created_at', '<', $start)->sum('jumlah') -
            PenjualanDetail::where('created_at', '<', $start)->sum('quantity');

        // Hitung stok masuk selama periode
        $stokMasuk = PembelianDetail::whereBetween('created_at', [$start, $end])->sum('jumlah');

        // Hitung stok keluar selama periode
        $stokKeluar = PenjualanDetail::whereBetween('created_at', [$start, $end])->sum('quantity');

        // Hitung stok akhir
        $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar;

        // Ambil data penjualan detail selama periode
        $dataPenjualan = PenjualanDetail::with(['produk', 'penjualan'])
            ->whereBetween('created_at', [$start, $end])
            ->get();

        // Ambil data pembelian detail selama periode
        $dataPembelian = PembelianDetail::with(['produk', 'pembelian'])
            ->whereBetween('created_at', [$start, $end])
            ->get();

        // Siapkan data untuk view
        $data = [
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'stokAwal' => $stokAwal,
            'stokMasuk' => $stokMasuk,
            'stokKeluar' => $stokKeluar,
            'stokAkhir' => $stokAkhir,
            'dataPenjualan' => $dataPenjualan,
            'dataPembelian' => $dataPembelian,
        ];

        // Render HTML untuk view PDF
        $html = view('report.pdf', $data)->render();

        // Inisialisasi Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Mengatur orientasi dan ukuran kertas
        $dompdf->setPaper('A4', 'landscape');

        // Menghasilkan dan mengunduh PDF
        return $dompdf->download('laporan_stok_' . $start->toDateString() . '_sampai_' . $end->toDateString() . '.pdf');
    }

    public function exportPDF(Request $request)
    {
        // Parsing tanggal
        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        // Hitung stok awal
        $stokAwal = PembelianDetail::where('created_at', '<', $start)->sum('jumlah') -
            PenjualanDetail::where('created_at', '<', $start)->sum('quantity');

        // Hitung stok masuk selama periode
        $stokMasuk = PembelianDetail::whereBetween('created_at', [$start, $end])->sum('jumlah');

        // Hitung stok keluar selama periode
        $stokKeluar = PenjualanDetail::whereBetween('created_at', [$start, $end])->sum('quantity');

        // Hitung stok akhir
        $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar;

        // Ambil data penjualan detail selama periode
        $dataPenjualan = PenjualanDetail::with(['produk', 'penjualan'])
            ->whereBetween('created_at', [$start, $end])
            ->get();

        // Ambil data pembelian detail selama periode
        $dataPembelian = PembelianDetail::with(['produk', 'pembelian'])
            ->whereBetween('created_at', [$start, $end])
            ->get();

        // Siapkan data untuk view
        $data = [
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'stokAwal' => $stokAwal,
            'stokMasuk' => $stokMasuk,
            'stokKeluar' => $stokKeluar,
            'stokAkhir' => $stokAkhir,
            'dataPenjualan' => $dataPenjualan,
            'dataPembelian' => $dataPembelian,
        ];

        // Render HTML untuk view PDF
        $html = view('report.pdf', $data);

        // Inisialisasi Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Mengatur orientasi dan ukuran kertas jika diperlukan
        $dompdf->setPaper('A4', 'landscape');

        // Render HTML menjadi PDF
        $dompdf->render();

        // Menghasilkan dan mengunduh PDF
        return $dompdf->stream('laporan_penjualan_' . $start->toDateString() . '_sampai_' . $end->toDateString() . '.pdf');
    }
}
