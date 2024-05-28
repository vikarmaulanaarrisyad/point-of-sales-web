@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Transaksi Penjualan</li>
@endsection

@push('css')
    <style>
        .hide {
            display: none;
        }

        .tampil-bayar {
            font-size: 4em;
            text-align: center;
            height: 100px;
        }

        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
        }

        .table-penjualan tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <x-card>

                <form class="form-produk">
                    @csrf
                    <div class="form-group row">
                        <label for="nama_produk" class="col-lg-2">Nama Produk</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input type="hidden" name="penjualan_id" id="penjualan_id" value="{{ $penjualan->id }}">
                                <input type="hidden" name="produk_id" id="produk_id">
                                <input type="hidden" name="stok" id="stok" value="{{ $stok }}">

                                <input id="nama_produk" class="form-control" type="text" name="">
                                <div class="input-group-append">
                                    <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"
                                        id="button-addon2"><i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <x-table class="table-penjualan">
                    <x-slot name="thead">
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga Lama</th>
                        <th>Harga Baru</th>
                        <th width="14%">Jumlah</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>

                <div class="row">
                    <div class="col-lg-7">
                        <div class="tampil-bayar bg-primary"></div>
                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-5">
                        <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                            @csrf
                            <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">
                            <input type="hidden" name="member" id="member">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 col-md-2 col-2 control-label">Total</label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_member" class="col-lg-2 col-md-2 col-2 control-label">Member</label>
                                <div class="col-lg-8 col-md-8">
                                    <div class="input-group">
                                        <input id="kode_member" class="form-control" type="text"
                                            value="{{ $memberSelected->kode_member }}">
                                        <div class="input-group-append" id="tambahPelanggan">
                                            <button onclick="tambahPelanggan('{{ route('pelanggan.store') }}')"
                                                class="btn btn-info btn-flat" type="button" id="button-addon2"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                        <div class="input-group-append">
                                            <button onclick="tampilMember()" class="btn btn-info btn-flat" type="button"
                                                id="button-addon2"><i class="fas fa-arrow-right"></i></button>
                                        </div>
                                        <div class="input-group-append">
                                            <button onclick="resetMember()" class="btn btn-info btn-flat" type="button"
                                                id="button-addon2"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control" autocomplete="off" readonly
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group row" id="form-diterima">
                                <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="text" id="diterima" class="form-control" autocomplete="off"
                                        name="diterima" value="{{ $penjualan->diterima ?? 0 }}"
                                        onkeyup="format_uang(this)">
                                </div>
                            </div>
                            <div class="form-group row" id="form-dp">
                                <label for="dp" class="col-lg-2 control-label">DP</label>
                                <div class="col-lg-8">
                                    <input type="text" id="dp" class="form-control" autocomplete="off"
                                        name="dp" value="0" onkeyup="format_uang(this)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembali" name="kembali" class="form-control"
                                        autocomplete="off" value="0" readonly disabled>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <x-slot name="footer">
                    <button type="submit" class="btn btn-primary btn-flat float-right btn-simpan"><i
                            class="fas fa-save"></i> Simpan
                        Transaksi</button>
                </x-slot>

            </x-card>
        </div>
    </div>
    @includeIf('admin.penjualan_detail.produk')
    @includeIf('admin.penjualan_detail.member')
    @includeIf('admin.penjualan_detail.formTambahMember')
@endsection

@include('includes.datatable')

@include('transaksi.penjualan_detail.scripts')
