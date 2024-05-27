<div class="row">
    <!-- Kolom Kiri -->
    <div class="col-md-6">
        <x-card>
            <x-slot name="header">
                <div class="alert alert-info alert-dismissible">
                    <h5><i class="icon fas fa-info"></i> Informasi!</h5>
                    Informasi Produk Terbaru
                </div>
            </x-slot>
            <div class="card-body">
                <ul>
                    <li>Produk A - Harga: Rp. 100.000</li>
                    <li>Produk B - Harga: Rp. 200.000</li>
                    <li>Produk C - Harga: Rp. 300.000</li>
                </ul>
            </div>
        </x-card>
    </div>

    <!-- Kolom Kanan -->
    <div class="col-md-6">
        <x-card>
            <x-slot name="header">
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-info"></i> Informasi!</h5>
                    Informasi Stok Produk kurang dari 10
                </div>
            </x-slot>
            <div class="card-body">
                <ul>
                    <li>Produk X - Stok: 5</li>
                    <li>Produk Y - Stok: 3</li>
                    <li>Produk Z - Stok: 8</li>
                </ul>
            </div>
        </x-card>
    </div>
</div>

<!-- Target Penjualan Per Karyawan -->
<div class="row mt-4">
    <div class="col-md-12">
        <x-card>
            <x-slot name="header">
                <h3 class="font-semibold text-gray-800 leading-tight">
                    Target Penjualan Per Karyawan
                </h3>
            </x-slot>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Target Penjualan</th>
                            <th>Penjualan Tercapai</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Karyawan 1</td>
                            <td>Rp. 10.000.000</td>
                            <td>Rp. 7.500.000</td>
                            <td>75%</td>
                        </tr>
                        <tr>
                            <td>Karyawan 2</td>
                            <td>Rp. 15.000.000</td>
                            <td>Rp. 12.000.000</td>
                            <td>80%</td>
                        </tr>
                        <tr>
                            <td>Karyawan 3</td>
                            <td>Rp. 20.000.000</td>
                            <td>Rp. 15.000.000</td>
                            <td>75%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>
