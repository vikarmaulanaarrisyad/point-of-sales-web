@extends('layouts.app')

@section('title', 'Data Produk')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card>
                @can('Jabatan Store')
                    <x-slot name="header">
                        <button onclick="addForm(`{{ route('product.store') }}`)" class="btn btn-sm btn-primary"><i
                                class="fas fa-plus-circle"></i> Tambah Data</button>
                    </x-slot>
                @endcan

                <x-table class="produk" style="width: 100%">
                    <x-slot name="thead">
                        <th width="7%">No</th>
                        <th>Barcode</th>
                        <th>Nama Produk</th>
                        <th>Satuan</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('masterdata.produk.form')
@endsection

@include('masterdata.produk.scripts')
