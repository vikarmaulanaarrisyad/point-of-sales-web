@extends('layouts.app')

@section('title', 'Data Kategori')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card class="">
                @can('Kategori Store')
                    <x-slot name="header">
                        <button onclick="addForm(`{{ route('category.store') }}`)" class="btn btn-sm btn-primary"><i
                                class="fas fa-plus-circle"></i> Tambah Data</button>
                    </x-slot>
                @endcan

                <x-table id="kategori" class="kategori" style="width: 100%">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Action</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('masterdata.kategori.form')
@endsection

@include('masterdata.kategori.scripts')
