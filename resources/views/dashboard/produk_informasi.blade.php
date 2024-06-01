<div class="row">
    <!-- Kolom Kiri -->
    @can('Produk Terbaru')
        <div class="col-md-6">
            <x-card>
                <x-slot name="header">
                    <div class="alert alert-info alert-dismissible">
                        <h5><i class="icon fas fa-info"></i> Informasi!</h5>
                        Informasi Produk Terbaru
                    </div>
                </x-slot>
                <div class="card-body">
                    <div class="col-lg-12">
                        <x-table>
                            <x-slot name="thead">
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </x-slot>

                            @foreach ($produkTerbaru as $key => $produk)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>{{ $produk->nama_produk }}</th>
                                    <th>{{ $produk->harga_jual }}</th>
                                    <th>{{ $produk->stok }}</th>
                                </tr>
                            @endforeach
                        </x-table>
                    </div>
                </div>
            </x-card>
        </div>
    @endcan

    <!-- Kolom Kanan -->
    @can('Stok Produk')
        <div class="col-md-6">
            <x-card>
                <x-slot name="header">
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-info"></i> Informasi!</h5>
                        Informasi Stok Produk kurang dari 10
                    </div>
                </x-slot>
                <div class="card-body">
                    <div class="col-lg-12">
                        <x-table>
                            <x-slot name="thead">
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </x-slot>

                            @foreach ($produkKurangStok as $key => $produk)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>{{ $produk->nama_produk }}</th>
                                    <th>{{ $produk->harga_jual }}</th>
                                    <th>{{ $produk->stok }}</th>
                                </tr>
                            @endforeach
                        </x-table>
                    </div>
                </div>
            </x-card>
        </div>
    @endcan
</div>

@can('Target Penjualan Karyawan')
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
@endcan
