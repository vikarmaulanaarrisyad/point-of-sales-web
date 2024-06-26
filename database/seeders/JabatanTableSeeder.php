<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jabatan::updateOrCreate(
            ['jabatan' => 'Karyawan'],
            ['jabatan' => 'Karyawan', 'slug' => 'karyawan']
        );
    }
}
