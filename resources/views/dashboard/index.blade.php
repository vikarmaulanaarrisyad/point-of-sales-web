@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{--  <x-card>  --}}
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-info"></i> Selamat Datang {{ Auth::user()->name }} !</h5>
                Pada aplikasi {{ $setting->company_name }}
            </div>
            {{--  </x-card>  --}}
        </div>
    </div>
    @includeIf('dashboard.small_box')
    @includeIf('dashboard.produk_informasi')
    {{--  @include('dashboard.grafik_chart')  --}}
@endsection
