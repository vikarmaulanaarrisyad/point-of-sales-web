@extends('layouts.app')

@section('title', 'Daftar Pembelian')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Pembelian</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    @if ($pembelianPending)
                        <a href="{{ route('pembelian.create') }}" class="btn btn-sm btn-danger">Transaksi Aktif</a>
                    @else
                        <a href="{{ route('pembelian.create') }}" class="btn btn-sm btn-danger">Transaksi Baru <i
                                class="fas fa-plus-circle"></i></a>
                    @endif

                </x-slot>
                <x-table class="pembelian">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('transaksi.pembelian.detail')
@endsection

@include('transaksi.pembelian.scripts')
