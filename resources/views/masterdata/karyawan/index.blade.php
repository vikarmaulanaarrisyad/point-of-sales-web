@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Karyawan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <div class="d-flex justify-content-between items-center">
                        <h5>Data Karyawan</h5>
                        @can('Karyawan Store')
                            <button onclick="addForm(`{{ route('karyawan.store') }}`)" class="btn btn-primary btn-sm"><i
                                    class="fas fa-plus-circle"></i> Tambah Data</button>
                        @endcan
                    </div>
                </x-slot>

                <x-table id="karyawan">
                    <x-slot name="thead">
                        <th width="6%">No</th>
                        <th>Foto</th>
                        <th>Nama Karyawan</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('masterdata.karyawan.form')
@endsection

@include('masterdata.karyawan.scripts')
