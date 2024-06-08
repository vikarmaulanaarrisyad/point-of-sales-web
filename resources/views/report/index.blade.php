@extends('layouts.app')

@section('title', 'Laporan Penjualan ' . tanggal_indonesia($start) . ' s/d ' . tanggal_indonesia($end))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan Penjualan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <button data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-primary">
                        <i class="fas fa-pencil-alt"></i> Ubah Periode
                    </button>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th>Harga Pabrik</th>
                        <th>Harga Jual</th>
                        <th>Laba</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('report.index') }}" method="GET">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-formLabel">Ubah Periode</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="start">Tanggal Mulai</label>
                            <input type="date" name="start" class="form-control" value="{{ $start }}" required>
                        </div>
                        <div class="form-group">
                            <label for="end">Tanggal Selesai</label>
                            <input type="date" name="end" class="form-control" value="{{ $end }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('report.form')
@endsection

@include('includes.datatable')
@include('includes.datepicker')

@push('scripts')
    <script>
        $(document).ready(function() {
            let modal = '#modal-form';

            $(".table").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('report.data', ['start' => $start, 'end' => $end]) }}",
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'harga_pabrik',
                        name: 'harga_pabrik'
                    },
                    {
                        data: 'harga_jual',
                        name: 'harga_jual'
                    },
                    {
                        data: 'profit',
                        name: 'profit'
                    },
                ],
                "paginate": false,
                "info": false,
                "searching": false,
                "order": []
            });
        });
    </script>
@endpush
