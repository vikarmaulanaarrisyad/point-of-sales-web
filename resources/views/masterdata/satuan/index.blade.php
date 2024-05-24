@extends('layouts.app')

@section('title', 'Data Satuan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Satuan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card class="">
                @can('Satuan Store')
                    <x-slot name="header">
                        <button onclick="addForm(`{{ route('satuan.store') }}`)" class="btn btn-sm btn-primary"><i
                                class="fas fa-plus-circle"></i> Tambah Data</button>
                    </x-slot>
                @endcan

                <x-table id="satuan" class="satuan" style="width: 100%">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Satuan</th>
                        <th>Action</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('masterdata.satuan.form')
@endsection

@include('masterdata.satuan.scripts')
