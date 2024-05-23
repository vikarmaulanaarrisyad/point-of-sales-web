@extends('layouts.app')

@section('title', 'Detail Karyawan ' . $karyawan->nama_karyawan)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('karyawan.index') }}">Karyawan</a></li>
    <li class="breadcrumb-item active">Detail Karyawan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ Storage::url($karyawan->photo) }}"
                            alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{ $karyawan->nama_karyawan }}</h3>
                    <p class="text-muted text-center">{{ $karyawan->nik_karyawan }}</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <table class="table">
                            <tr>
                                <td>Jabatan</td>
                                <td></td>
                                <td>{{ $karyawan->jabatan->jabatan }}</td>
                            </tr>
                            <tr>
                                <td>Kontak</td>
                                <td></td>
                                <td>{{ $karyawan->no_telp_karyawan }}</td>
                            </tr>
                        </table>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <x-card>
                <table class="table" style="width: 100%">
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td>{{ $karyawan->tempat_lahir }}, {{ tanggal_indonesia($karyawan->tgl_lahir_karyawan) }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>{{ $karyawan->jenis_kelamin_karyawan }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $karyawan->alamat_karyawan }}</td>
                    </tr>
                    <tr>
                        <td>Target Penjualan Perbulan</td>
                        <td>:</td>
                        <td>{{ $karyawan->target_penjualan_bulan }}</td>
                    </tr>
                    <tr>
                        <td>Target Penjualan Perhari</td>
                        <td>:</td>
                        <td>{{ $karyawan->target_penjualan_hari }}</td>
                    </tr>
                </table>
            </x-card>
        </div>
    </div>
@endsection
