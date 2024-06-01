@extends('layouts.app')

@section('title', 'Daftar Penjualan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Penjualan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-table class="penjualan">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Invoice</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('transaksi.penjualan.detail')
@endsection

@include('transaksi.penjualan.scripts')
