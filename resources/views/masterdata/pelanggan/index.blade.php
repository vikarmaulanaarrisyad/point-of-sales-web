@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Pelanggan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <div class="d-flex justify-content-between items-center">
                        <h5>Data Pelanggan</h5>
                        @can('Pelanggan Store')
                            <button onclick="addForm(`{{ route('pelanggan.store') }}`)" class="btn btn-primary btn-sm"><i
                                    class="fas fa-plus-circle"></i> Tambah Data</button>
                        @endcan
                    </div>
                </x-slot>

                @can('Filter Karyawan')
                    <div class="d-flex justify-content-between">
                        <div class="form-group">
                            <label for="filter_karyawan">Pilih Karyawan</label>
                            <select name="filter_karyawan" id="filter_karyawan" class="custom-select">
                                <option value="" selected>Semua</option>
                                @foreach ($karyawan as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_karyawan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endcan

                <x-table id="pelanggan">
                    <x-slot name="thead">
                        <th width="6%">No</th>
                        <th>Nama Toko</th>
                        <th>Nama Pemilik</th>
                        <th>Nomor Hp</th>
                        <th>Alamat</th>
                        <th>Karyawan</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('masterdata.pelanggan.form')
@endsection

@include('masterdata.pelanggan.scripts')
