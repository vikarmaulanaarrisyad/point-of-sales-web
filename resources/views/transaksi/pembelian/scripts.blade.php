@include('includes.datatable')

@push('scripts')
    <script>
        let pembelianDetail, penjualan;
        let modal = '#modal-form';
        let modalDetail = '.modal-detail';
        let button = '#submitBtn';

        $(function() {
            $('#spinner-border').hide();
        });
    </script>

    <script>
        pembelian = $('.pembelian').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            language: {
                "processing": "Mohon bersabar..."
            },
            ajax: {
                url: '{{ route('pembelian.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'supplier'
                },
                {
                    data: 'total_item'
                },
                {
                    data: 'total_harga'
                },
                {
                    data: 'bayar'
                },
                {
                    data: 'aksi',
                    searchable: false,
                    sortable: false
                },
            ],
        })

        pembelianDetail = $('.penjualan-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'nama_produk',
                },
                {
                    data: 'harga',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'jumlah',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'subtotal',
                    sortable: false,
                    searchable: false
                },
            ]
        });
    </script>

    <script>
        function addForm(url) {
            //$(modal).modal('show');
            //$(`${modal} .modal-title`).text(title);
            window.location.href = url;
        }

        function addData(url, title = 'Tambah') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('POST');

            $('#spinner-border').hide();

            $(button).show();
            $(button).prop('disabled', false);

            resetForm(`${modal} form`);
        }

        function showDetail(url, title = "Detail Pembelian") {
            $(modalDetail).modal('show');
            $(`${modalDetail} .modal-title`).text(title);

            pembelianDetail.ajax.url(url);
            pembelianDetail.ajax.reload();
        }

        function deleteData(url, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menghapus ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya Hapus',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: url,
                        dataType: "json",
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    window.location.reload();
                                    //pembelianDetail.ajax.reload();
                                    //penjualan.ajax.reload();
                                })
                            }
                        },
                        error: function(xhr, status, error) {
                            // Menampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: xhr.responseJSON.message,
                                showConfirmButton: true,
                            }).then(() => {
                                // Refresh tabel atau lakukan operasi lain yang diperlukan
                                //pembelianDetail.ajax.reload();
                                // penjualan.ajax.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush
