<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KaryawanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = new User();
        $user1->name = 'Karyawan 1';
        $user1->email = 'karyawan1@karyawan1';
        $user1->password = Hash::make('password');
        $user1->save();

        $k1 = new Karyawan();
        $k1->user_id = $user1->id;
        $k1->jabatan_id = 1;
        $k1->nama_karyawan = 'Karyawan 1';
        $k1->nik_karyawan = '1223456789012345';
        $k1->tempat_lahir = 'Tegal';
        $k1->tgl_lahir_karyawan = '2001-01-01';
        $k1->jenis_kelamin_karyawan = 'Laki-laki';
        $k1->no_telp_karyawan = '08';
        $k1->alamat_karyawan = 'Tegla';
        $k1->target_penjualan_bulan = 1000000;
        $k1->target_penjualan_harian = 1000000;
        $k1->photo = 'default.png';
        $k1->save();
    }
}
