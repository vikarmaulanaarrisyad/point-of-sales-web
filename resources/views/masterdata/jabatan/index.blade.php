@extends('layouts.app')

@section('title', 'Data Jabatan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Jabatan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card>
                @can('Jabatan Store')
                    <x-slot name="header">
                        <button onclick="addForm(`{{ route('jabatan.store') }}`)" class="btn btn-sm btn-info"><i
                                class="fas fa-plus-circle"></i> Tambah Data</button>
                    </x-slot>
                @endcan

                <x-table id="jabatan" class="jabatan" style="width: 100%">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Nama Jabatan</th>
                        <th>Action</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('masterdata.jabatan.form')
@endsection

@include('masterdata.jabatan.scripts')
