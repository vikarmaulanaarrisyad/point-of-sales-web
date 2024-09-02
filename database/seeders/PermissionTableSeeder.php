<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'Dashboard Index',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Master Data',
                'permission_group_id' => PermissionGroup::where('name', 'Master Data')->first()->id,
            ],

            // KONFIGURASI
            [
                'name' => 'Konfigurasi Index',
                'permission_group_id' => PermissionGroup::where('name', 'Konfigurasi')->first()->id,
            ],
            [
                'name' => 'User Index',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'User Store',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'User Show',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'User Edit',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'User Update',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'User Delete',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'Role Index',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Role Store',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Role Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Role Show',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Role Update',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Role Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Permission Index',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Permission Store',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Permission Show',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Permission Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Permission Update',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Permission Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Index',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Store',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Show',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Update',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],

            [
                'name' => 'Jabatan Index',
                'permission_group_id' => PermissionGroup::where('name', 'Jabatan')->first()->id,
            ],
            [
                'name' => 'Jabatan Store',
                'permission_group_id' => PermissionGroup::where('name', 'Jabatan')->first()->id,
            ],
            [
                'name' => 'Jabatan Show',
                'permission_group_id' => PermissionGroup::where('name', 'Jabatan')->first()->id,
            ],
            [
                'name' => 'Jabatan Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Jabatan')->first()->id,
            ],
            [
                'name' => 'Jabatan Update',
                'permission_group_id' => PermissionGroup::where('name', 'Jabatan')->first()->id,
            ],
            [
                'name' => 'Jabatan Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Jabatan')->first()->id,
            ],

            [
                'name' => 'Satuan Index',
                'permission_group_id' => PermissionGroup::where('name', 'Satuan')->first()->id,
            ],
            [
                'name' => 'Satuan Store',
                'permission_group_id' => PermissionGroup::where('name', 'Satuan')->first()->id,
            ],
            [
                'name' => 'Satuan Show',
                'permission_group_id' => PermissionGroup::where('name', 'Satuan')->first()->id,
            ],
            [
                'name' => 'Satuan Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Satuan')->first()->id,
            ],
            [
                'name' => 'Satuan Update',
                'permission_group_id' => PermissionGroup::where('name', 'Satuan')->first()->id,
            ],
            [
                'name' => 'Satuan Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Satuan')->first()->id,
            ],

            [
                'name' => 'Produk Index',
                'permission_group_id' => PermissionGroup::where('name', 'Produk')->first()->id,
            ],
            [
                'name' => 'Produk Store',
                'permission_group_id' => PermissionGroup::where('name', 'Produk')->first()->id,
            ],
            [
                'name' => 'Produk Show',
                'permission_group_id' => PermissionGroup::where('name', 'Produk')->first()->id,
            ],
            [
                'name' => 'Produk Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Produk')->first()->id,
            ],
            [
                'name' => 'Produk Update',
                'permission_group_id' => PermissionGroup::where('name', 'Produk')->first()->id,
            ],
            [
                'name' => 'Produk Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Produk')->first()->id,
            ],

            [
                'name' => 'Karyawan Index',
                'permission_group_id' => PermissionGroup::where('name', 'Karyawan')->first()->id,
            ],
            [
                'name' => 'Karyawan Store',
                'permission_group_id' => PermissionGroup::where('name', 'Karyawan')->first()->id,
            ],
            [
                'name' => 'Karyawan Show',
                'permission_group_id' => PermissionGroup::where('name', 'Karyawan')->first()->id,
            ],
            [
                'name' => 'Karyawan Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Karyawan')->first()->id,
            ],
            [
                'name' => 'Karyawan Detail',
                'permission_group_id' => PermissionGroup::where('name', 'Karyawan')->first()->id,
            ],
            [
                'name' => 'Karyawan Update',
                'permission_group_id' => PermissionGroup::where('name', 'Karyawan')->first()->id,
            ],
            [
                'name' => 'Karyawan Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Karyawan')->first()->id,
            ],

            [
                'name' => 'Pelanggan Index',
                'permission_group_id' => PermissionGroup::where('name', 'Pelanggan')->first()->id,
            ],
            [
                'name' => 'Pelanggan Store',
                'permission_group_id' => PermissionGroup::where('name', 'Pelanggan')->first()->id,
            ],
            [
                'name' => 'Pelanggan Show',
                'permission_group_id' => PermissionGroup::where('name', 'Pelanggan')->first()->id,
            ],
            [
                'name' => 'Pelanggan Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Pelanggan')->first()->id,
            ],
            [
                'name' => 'Pelanggan Detail',
                'permission_group_id' => PermissionGroup::where('name', 'Pelanggan')->first()->id,
            ],
            [
                'name' => 'Pelanggan Update',
                'permission_group_id' => PermissionGroup::where('name', 'Pelanggan')->first()->id,
            ],
            [
                'name' => 'Pelanggan Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Pelanggan')->first()->id,
            ],

            [
                'name' => 'Kategori Index',
                'permission_group_id' => PermissionGroup::where('name', 'Kategori')->first()->id,
            ],
            [
                'name' => 'Kategori Store',
                'permission_group_id' => PermissionGroup::where('name', 'Kategori')->first()->id,
            ],
            [
                'name' => 'Kategori Show',
                'permission_group_id' => PermissionGroup::where('name', 'Kategori')->first()->id,
            ],
            [
                'name' => 'Kategori Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Kategori')->first()->id,
            ],
            [
                'name' => 'Kategori Update',
                'permission_group_id' => PermissionGroup::where('name', 'Kategori')->first()->id,
            ],
            [
                'name' => 'Kategori Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Kategori')->first()->id,
            ],

            [
                'name' => 'Transaksi Index',
                'permission_group_id' => PermissionGroup::where('name', 'Transaksi')->first()->id,
            ],
            [
                'name' => 'Transaksi Baru',
                'permission_group_id' => PermissionGroup::where('name', 'Transaksi')->first()->id,
            ],
            [
                'name' => 'Transaksi Store',
                'permission_group_id' => PermissionGroup::where('name', 'Transaksi')->first()->id,
            ],
            [
                'name' => 'Transaksi Show',
                'permission_group_id' => PermissionGroup::where('name', 'Transaksi')->first()->id,
            ],
            [
                'name' => 'Transaksi Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Transaksi')->first()->id,
            ],
            [
                'name' => 'Transaksi Update',
                'permission_group_id' => PermissionGroup::where('name', 'Transaksi')->first()->id,
            ],
            [
                'name' => 'Transaksi Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Transaksi')->first()->id,
            ],

            [
                'name' => 'Pengaturan Index',
                'permission_group_id' => PermissionGroup::where('name', 'Pengaturan')->first()->id,
            ],

            // GRAFIK
            [
                'name' => 'Grafik Chart Penjualan',
                'permission_group_id' => PermissionGroup::where('name', 'Grafik')->first()->id,
            ],
            [
                'name' => 'Total Produk',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Total Kategori',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Total Pelanggan',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Total Karyawan',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Total Penjualan Harian',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Total Laba Harian',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Total Penjualan Perbulan',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Total Laba Perbulan',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Total Penjualan Pertahun',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Total Laba Pertahun',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Produk Terbaru',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Stok Produk',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Target Penjualan Karyawan',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Report Index',
                'permission_group_id' => PermissionGroup::where('name', 'Report')->first()->id,
            ],
        ];

        foreach ($permissions as $value) {
            $permission = new Permission;
            $permission->name = $value['name'];
            $permission->permission_group_id = $value['permission_group_id'];
            $permission->save();
        }
    }
}
