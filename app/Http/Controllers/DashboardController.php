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

        return view('dashboard.index', compact([
            'totalProduk',
            'totalKategori',
            'totalPelanggan',
            'totalKaryawan'
        ]));
    }
}
