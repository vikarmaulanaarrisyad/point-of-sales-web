<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionGroupTableSeeder::class,
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            // UserTableSeeder::class,
            // SettingSeeder::class,
            // JabatanTableSeeder::class,
            // KaryawanTableSeeder::class,
            // PelangganTableSeeder::class,
            // CategoryTableSeeder::class,
            // SatuanTableSeeder::class,
            // ProdukTableSeeder::class,
        ]);
    }
}
