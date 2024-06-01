<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalKategori = Category::count();
        $totalPelanggan = Pelanggan::count();
        $totalKaryawan = Karyawan::count();

        // Ambil 10 produk terbaru berdasarkan tanggal pembuatan
        $produkTerbaru = Product::orderBy('created_at', 'desc')->take(10)->get();

        // Ambil produk dengan stok kurang dari 10
        $produkKurangStok = Product::where('stok', '<', 10)->get();

        $tahun = date('Y'); // Tahun yang ingin Anda analisis
        $karyawan = new Karyawan();
        $targetPenjualanPerBulan = $karyawan->hitungTargetPenjualanPerBulan($tahun);
        // dd($targetPenjualanPerBulan);

        return view('dashboard.index', compact(
            'totalProduk',
            'totalKategori',
            'totalPelanggan',
            'totalKaryawan',
            'produkTerbaru',
            'produkKurangStok',
            'targetPenjualanPerBulan'
        ));
    }
}
