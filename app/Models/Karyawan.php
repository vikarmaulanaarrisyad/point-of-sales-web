<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }


    public function hitungTargetPenjualan()
    {
        // Ambil semua data karyawan beserta target penjualan mereka
        $karyawan = Karyawan::with('penjualan')->get();

        $targetTotal = 0;
        $penjualanTotal = 0;
        $targetPerKaryawan = [];

        // Loop melalui setiap karyawan
        foreach ($karyawan as $karyawan) {
            $target = $karyawan->target_penjualan_bulan; // Sesuaikan dengan nama kolom target penjualan di tabel Karyawan
            $penjualan = $karyawan->penjualan->sum('total_bayar'); // Sesuaikan dengan nama kolom total bayar di tabel Penjualan

            // Hitung target total dan penjualan total
            $targetTotal += $target;
            $penjualanTotal += $penjualan;

            // Hitung target penjualan per karyawan
            $targetPerKaryawan[$karyawan->nama_karyawan] = [
                'target' => $target,
                'penjualan' => $penjualan,
                'selisih' => $target - $penjualan, // Selisih antara target dan penjualan
            ];
        }

        // Handle division by zero
        $persentasePencapaian = $targetTotal != 0 ? ($penjualanTotal / $targetTotal) * 100 : 0;

        return [
            'target_total' => $targetTotal,
            'penjualan_total' => $penjualanTotal,
            'persentase_pencapaian' => $persentasePencapaian,
            'target_per_karyawan' => $targetPerKaryawan,
        ];
    }

    public function hitungTargetPenjualanPerBulan($tahun)
    {
        $karyawan = Karyawan::with('penjualan')->get();
        $targetPerKaryawan = [];

        foreach ($karyawan as $karyawan) {
            $targetPerBulan = [];

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $target = $karyawan->target_penjualan_bulan; // Kolom target penjualan per bulan
                $penjualan = $karyawan->penjualan()
                    ->whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $bulan)
                    ->sum('total_bayar');

                // Hanya masukkan data jika ada penjualan atau persentase penjualan
                if ($penjualan > 0 || $target != 0) {
                    $persentase = $target != 0 ? ($penjualan / $target) * 100 : 0;
                    $persentase = min($persentase, 100); // Batasi persentase maksimal 100%
                    $persentase = floor($persentase); // Membulatkan ke bawah
                    $targetPerBulan[$bulan] = [
                        'target' => $target,
                        'penjualan' => $penjualan,
                        'persentase' => $persentase, // Hitung persentase dengan batasan 100%
                    ];
                }
            }

            if (!empty($targetPerBulan)) {
                $targetPerKaryawan[$karyawan->nama_karyawan] = $targetPerBulan;
            }
        }

        return $targetPerKaryawan;
    }
}
