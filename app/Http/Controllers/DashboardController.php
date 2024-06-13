<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index1()
    {
        // Set timezone and locale
        Carbon::setLocale('id');
        $carbon = new Carbon();
        $carbon->setTimezone('Asia/Jakarta');

        $totalProduk = Product::count();
        $totalKategori = Category::count();
        $totalPelanggan = Pelanggan::count();
        $totalKaryawan = Karyawan::count();
        $produkTerbaru = Product::latest()->take(10)->get();
        $produkKurangStok = Product::where('stok', '<', 10)->get();
        $tahun = date('Y');
        $karyawan = new Karyawan();
        $targetPenjualanPerBulan = $karyawan->hitungTargetPenjualanPerBulan($tahun);

        // Calculate daily profit and total sales per day
        $dailyProfits = [];
        $totalSalesPerDay = [];
        $startDate = $carbon->copy()->subDays(30);
        $endDate = $carbon->copy();
        $dateRange = $startDate->copy()->toPeriod($endDate)->days();

        foreach ($dateRange as $date) {
            $formattedDate = $date->format('Y-m-d');
            $totalSales = Penjualan::whereDate('created_at', $formattedDate)->sum('total_harga');
            $totalCost = Penjualan::whereDate('created_at', $formattedDate)->sum('total_item') * Product::avg('harga_beli');
            $dailyProfit = $totalSales - $totalCost;

            $dailyProfits[$formattedDate] = $dailyProfit;
            $totalSalesPerDay[$formattedDate] = $totalSales;
        }

        // Calculate monthly profit and total sales per month
        $monthlyProfits = [];
        $totalSalesPerMonth = [];
        $currentYear = $carbon->copy()->format('Y');
        $currentMonth = $carbon->copy()->format('m');
        $monthRange = $currentMonth;

        for ($month = 1; $month <= $monthRange; $month++) {
            $totalSales = Penjualan::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('total_harga');
            $totalCost = Penjualan::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('total_item') * Product::avg('harga_beli');
            $monthlyProfit = $totalSales - $totalCost;

            $monthlyProfits[$month] = round($monthlyProfit);
            $totalSalesPerMonth[$month] = $totalSales;
        }

        $totalSalesToday = Penjualan::whereDate('created_at', $endDate)->sum('total_harga');

        // Calculate daily profit and total sales per day
        $dailyProfits = [];
        $totalSalesPerDay = [];
        $dailyProfit = 0; // Initialize daily profit variable

        foreach ($dateRange as $date) {
            $formattedDate = $date->format('Y-m-d');
            $totalSales = Penjualan::whereDate('created_at', $formattedDate)->sum('total_harga');
            $totalCost = Penjualan::whereDate('created_at', $formattedDate)->sum('total_item') * Product::avg('harga_beli');
            $dailyProfit += $totalSales - $totalCost; // Accumulate daily profit

            $dailyProfits[$formattedDate] = $dailyProfit;
            $totalSalesPerDay[$formattedDate] = $totalSales;
        }

        // Calculate yearly profit and total sales per year
        $totalSalesPerYear = Penjualan::whereYear('created_at', $currentYear)->sum('total_harga');
        $totalCostPerYear = Penjualan::whereYear('created_at', $currentYear)->sum('total_item') * Product::avg('harga_beli');
        $yearlyProfit = $totalSalesPerYear - $totalCostPerYear;

        $totalSalesToday = Penjualan::whereDate('created_at', $endDate)->sum('total_harga');

        return view('dashboard.index', compact(
            'totalProduk',
            'totalKategori',
            'totalPelanggan',
            'totalKaryawan',
            'produkTerbaru',
            'produkKurangStok',
            'targetPenjualanPerBulan',
            'dailyProfits',
            'dailyProfit',
            'totalSalesPerDay',
            'monthlyProfits',
            'totalSalesPerMonth',
            'totalSalesToday',
            'totalSalesPerYear',
            'yearlyProfit'
        ));
    }

    public function index()
    {
        // Set timezone and locale
        Carbon::setLocale('id');
        $carbon = new Carbon();
        $carbon->setTimezone('Asia/Jakarta');

        $totalProduk = Product::count();
        $totalKategori = Category::count();
        $totalPelanggan = Pelanggan::count();
        $totalKaryawan = Karyawan::count();
        $produkTerbaru = Product::latest()->take(10)->get();
        $produkKurangStok = Product::where('stok', '<', 10)->get();
        $tahun = date('Y');
        $karyawan = new Karyawan();
        $targetPenjualanPerBulan = $karyawan->hitungTargetPenjualanPerBulan($tahun);

        // Calculate daily profit and total sales per day
        $dailyProfits = [];
        $totalSalesPerDay = [];
        $startDate = $carbon->copy()->subDays(30);
        $endDate = $carbon->copy();
        $dateRange = $startDate->copy()->toPeriod($endDate)->days();

        foreach ($dateRange as $date) {
            $formattedDate = $date->format('Y-m-d');
            $totalSales = Penjualan::whereDate('created_at', $formattedDate)->sum('total_harga');
            $totalCost = Penjualan::whereDate('created_at', $formattedDate)->sum('total_item') * Product::avg('harga_beli');
            $dailyProfit = $totalSales - $totalCost;

            $dailyProfits[$formattedDate] = round($dailyProfit);
            $totalSalesPerDay[$formattedDate] = $totalSales;
        }

        // Calculate monthly profit and total sales per month
        $monthlyProfits = [];
        $totalSalesPerMonth = [];
        $currentYear = $carbon->copy()->format('Y');

        for ($month = 1; $month <= 12; $month++) {
            $totalSales = Penjualan::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('total_harga');
            $totalCost = Penjualan::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('total_item') * Product::avg('harga_beli');
            $monthlyProfit = $totalSales - $totalCost;

            $monthlyProfits[$month] = round($monthlyProfit);
            $totalSalesPerMonth[$month] = $totalSales;
        }

        // Calculate yearly profit and total sales per year
        $totalSalesPerYear = Penjualan::whereYear('created_at', $currentYear)->sum('total_harga');
        $totalCostPerYear = Penjualan::whereYear('created_at', $currentYear)->sum('total_item') * Product::avg('harga_beli');
        $yearlyProfit = $totalSalesPerYear - $totalCostPerYear;

        $totalSalesToday = Penjualan::whereDate('created_at', $endDate)->sum('total_harga');
        return view('dashboard.index', compact(
            'totalProduk',
            'totalKategori',
            'totalPelanggan',
            'totalKaryawan',
            'produkTerbaru',
            'produkKurangStok',
            'targetPenjualanPerBulan',
            'dailyProfits',
            'totalSalesPerDay',
            'monthlyProfits',
            'totalSalesPerMonth',
            'totalSalesToday',
            'totalSalesPerYear',
            'yearlyProfit',
            'dailyProfit'
        ));
    }
}
