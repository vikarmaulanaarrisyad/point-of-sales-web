@extends('layouts.app')

@section('title', 'Permission')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Konfigurasi</li>
    <li class="breadcrumb-item active">Permission</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card>
                @can('Permission Store')
                    <x-slot name="header">
                        <button onclick="addFormPermission(`{{ route('permission.store') }}`)" class="btn btn-sm btn-info"><i
                                class="fas fa-plus-circle"></i>
                            Tambah Data</button>
                    </x-slot>
                @endcan
                <x-table id="permissionTable" class="permissionTable" style="width: 100%">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Name</th>
                        <th>Group</th>
                        <th>Action</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('konfigurasi.permission.form')
@endsection

@include('konfigurasi.permission.scripts')
