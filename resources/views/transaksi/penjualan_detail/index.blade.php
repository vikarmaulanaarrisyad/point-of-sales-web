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
                        <label for="barcode" class="col-lg-2">Nama Produk</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input type="hidden" name="penjualan_id" id="penjualan_id" value="{{ $penjualan->id }}">
                                <input type="hidden" name="product_id" id="product_id">

                                <input id="barcode" class="form-control" type="text" name="barcode">

                                <div class="input-group-append">
                                    <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i
                                            class="fas fa-arrow-right"></i></button>
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
                        <th>Harga</th>
                        <th width="14%">Jumlah</th>
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
                            <input type="hidden" name="pelanggan" id="pelanggan">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 col-md-2 col-2 control-label">Total</label>
                                <div class="col-lg-8 col-md-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_toko" class="col-lg-2 col-md-2 col-2 control-label">Nama Toko</label>
                                <div class="col-lg-8 col-md-8">
                                    <div class="input-group">
                                        <input id="nama_toko" class="form-control" type="text"
                                            value="{{ $memberSelected->nama_toko }}">
                                        <div class="input-group-append" id="tambahPelanggan">
                                            <button onclick="tambaPelanggan('{{ route('pelanggan.store') }}')"
                                                class="btn btn-info btn-flat" type="button"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                        <div class="input-group-append">
                                            <button onclick="tampilPelanggan()" class="btn btn-info btn-flat"
                                                type="button"><i class="fas fa-arrow-right"></i></button>
                                        </div>
                                        <div class="input-group-append">
                                            <button onclick="resetPelanggan()" class="btn btn-info btn-flat"
                                                type="button"><i class="fas fa-sync-alt"></i></button>
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
                            class="fas fa-save"></i> Simpan Transaksi</button>
                </x-slot>

            </x-card>
        </div>
    </div>
    @include('transaksi.penjualan_detail.produk')
    @include('transaksi.penjualan_detail.pelanggan')
    @include('transaksi.penjualan_detail.form_pelanggan')
@endsection

@include('includes.datatable')

@include('transaksi.penjualan_detail.scripts')
