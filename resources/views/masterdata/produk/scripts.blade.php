@include('includes.datatable')
@include('includes.select2')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';

        $(function() {
            $('#spinner-border').hide();
        });

        table = $('.table').DataTable({
            processing: false,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('product.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'barcode',
                },
                {
                    data: 'nama_produk',
                },
                {
                    data: 'satuan',
                },
                {
                    data: 'harga_beli',
                },
                {
                    data: 'harga_jual',
                },
                {
                    data: 'stok',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#kategori').select2({
            placeholder: 'Pilih Kategori',
            theme: 'bootstrap4',
            closeOnSelect: true,
            allowClear: true,
            time: 250,
            ajax: {
                url: '{{ route('category.search') }}',
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        });

        $('#satuan').select2({
            placeholder: 'Pilih Satuan',
            theme: 'bootstrap4',
            closeOnSelect: true,
            allowClear: true,
            time: 250,
            ajax: {
                url: '{{ route('satuan.search') }}',
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        });


        function addForm(url, title = 'Form Tambah Data Produk') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');

            resetForm(`${modal} form`);
        }

        function editForm(url, title = 'Form Edit Data Produk') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');

                    resetForm(`${modal} form`);
                    loopForm(response.data);

                    var optionSatuan = new Option(response.data.satuan.name, response.data.satuan.id, true, true);
                    $('#satuan').append(optionSatuan).trigger('change');

                    var optionCategory = new Option(response.data.category.name, response.data.category.id, true, true);
                    $('#kategori').append(optionCategory).trigger('change');
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                    }
                });
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
                title: 'Delete Data!',
                text: 'Apakah anda yakin ingin menghapus ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya !',
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
                                    table.ajax.reload();
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
                                table.ajax.reload();
                            });
                        }
                    });
                }
            });
        }

        function submitForm(originalForm) {
            $(button).prop('disabled', true);
            $('#spinner-border').show();

            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            $(button).prop('disabled', false);
                            $('#spinner-border').hide();

                            table.ajax.reload();
                        })
                    }
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }
    </script>
@endpush
