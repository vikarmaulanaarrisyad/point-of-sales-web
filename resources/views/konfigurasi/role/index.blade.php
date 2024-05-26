@extends('layouts.app')

@section('title', 'Konfigurasi')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Role</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card>
                @can('Role Store')
                    <x-slot name="header">
                        <button onclick="addFormRole(`{{ route('role.store') }}`)" class="btn btn-sm btn-primary"><i
                                class="fas fa-plus-circle"></i>
                            Tambah Data</button>
                    </x-slot>
                @endcan

                <x-table id="roleTable" class="roleTable" style="width: 100%">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Name</th>
                        <th>Guard Name</th>
                        <th>Action</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('konfigurasi.role.form')
@endsection

@include('konfigurasi.role.scripts')
