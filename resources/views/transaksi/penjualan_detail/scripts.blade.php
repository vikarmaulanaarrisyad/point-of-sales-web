@push('scripts')
    <script>
        let table1, table2, table3;
        let modal = '#modal-form';
        let modalPelanggan = '.modal-pelanggan';
        let modalTambahPelanggan = '.modal-tambah-pelangggan';
        let button = '#submitBtn';

        $(function() {
            $('#spinner-border').hide();
            $('#nama_produk').focus();
            $('body').addClass('sidebar-collapse');
            $('#nama_toko').prop('disabled', true);
            $('.btn-simpan').prop('disabled', true);
            $('#tambahPelanggan').hide();
            $('#form-dp').hide();

            $('input[name="status"]').change(function() {
                if ($(this).val() == "Cash") {
                    $('#tambahPelanggan').hide();
                    $('.btn-simpan').prop('disabled', true);
                    $('#form-dp').hide();
                    $('#form-diterima').show();
                } else {
                    $('#tambahPelanggan').show();
                    $('#form-diterima').hide();
                    $('#form-dp').show();
                    $('.btn-simpan').prop('disabled', false);
                }
            });
        });

        $(document).on('input', '.quantity', function() {
            let id = $(this).data('id');
            let jumlah = parseInt($(this).val());
            let harga_jual = $('#harga_jual').val();
            harga_jual = harga_jual.replace('.', '');

            if (harga_jual < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Opps! Gagal',
                    text: 'Harga baru tidak boleh kurang dari 0',
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    harga_beli.val();
                });
                return;
            }

            if (jumlah < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Opps! Gagal',
                    text: 'Jumlah tidak boleh kurang dari 1',
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    $(this).val(1);
                });
                return;
            }

            if (jumlah > 10000) {
                Swal.fire({
                    icon: 'error',
                    title: 'Opps! Gagal',
                    text: 'Jumlah tidak boleh melebihi 10000',
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    $(this).val(10000);
                });
                return;
            }
            $.post(`{{ url('transaksi') }}/${id} `, {
                    _method: 'PUT',
                    _token: '{{ csrf_token() }}',
                    jumlah,
                    harga_jual
                })
                .done(response => {
                    table1.ajax.reload();
                    table2.ajax.reload();
                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message ?? 'Tidak dapat menyimpan data ke server',
                        showConfirmButton: false,
                        timer: 3000,
                    }).then(() => {
                        $(this).val(1);
                    });
                });
        });

        $(document).on('change', '.harga_jual', function() {
            let id = $(this).data('id');
            let jumlah = $('.quantity').val();
            let harga_jual = $('#harga_jual').val();
            harga_jual = harga_jual.replace('.', '');

            if (harga_jual < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Opps! Gagal',
                    text: 'Harga baru tidak boleh kurang dari 0',
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    harga_beli.val();
                });
                return;
            }

            if (jumlah < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Opps! Gagal',
                    text: 'Jumlah tidak boleh kurang dari 1',
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    $(this).val(1);
                });
                return;
            }

            if (jumlah > 10000) {
                Swal.fire({
                    icon: 'error',
                    title: 'Opps! Gagal',
                    text: 'Jumlah tidak boleh melebihi 10000',
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    $(this).val(10000);
                });
                return;
            }
            $.post(`{{ url('transaksi') }}/${id} `, {
                    _method: 'PUT',
                    _token: '{{ csrf_token() }}',
                    jumlah,
                    harga_jual
                })
                .done(response => {
                    table1.ajax.reload();
                    table2.ajax.reload();
                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message ?? 'Tidak dapat menyimpan data ke server',
                        showConfirmButton: false,
                        timer: 3000,
                    }).then(() => {
                        $(this).val(1);
                    });
                });
        });

        $('#diterima').on('input', function() {
            // Mengonversi nilai menjadi angka untuk memastikan perbandingan numerik yang benar
            var jumlahDiterima = $(this).val().replace(/[^\d]/g, '');
            var totalBayar = $('#bayar').val();

            if (jumlahDiterima === '' || jumlahDiterima == 0) {
                $('.btn-simpan').prop('disabled', true);
                $(this).val('0').select();
            } else {
                $('.btn-simpan').prop('disabled', false);
            }

            loadForm($('#diskon').val(), jumlahDiterima);
        }).focus(function() {
            $(this).select();
        });

        $('.btn-simpan').on('click', function() {
            let form = $('.form-penjualan');
            form.submit();
        })
    </script>

    <script>
        table1 = $('.table-penjualan').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            language: {
                "processing": "Mohon bersabar..."
            },
            ajax: {
                url: '{{ route('transaksi.data', $penjualan->id) }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'barcode',
                },
                {
                    data: 'nama_produk',
                },
                {
                    data: 'harga_jual',
                },
                {
                    data: 'jumlah',
                },
                {
                    data: 'subtotal',
                },
                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
                },
            ],
            dom: 'Brt',
            bSort: false,
        }).on('draw.dt', function() {
            loadForm($('#diskon').val());
            setTimeout(() => {
                $('#diterima').trigger('input');
            }, 300);
        });


        table2 = $('.table-produk').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            language: {
                "processing": "Mohon bersabar..."
            },
            ajax: {
                url: '{{ route('penjualan_detail.produk') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'nama_produk',
                },
                {
                    data: 'harga_beli',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
                },
            ],
            dom: 'Brt',
            bSort: false,
        });

        table3 = $('.table-pelanggan').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            language: {
                "processing": "Mohon bersabar..."
            },
            ajax: {
                url: '{{ route('transaksi.pelanggan') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'nama_toko',
                    sortable: false,
                },
                {
                    data: 'nama_pemilik',
                },
                {
                    data: 'alamat',
                },
                {
                    data: 'nomor_hp',
                },
                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
                },
            ],
            dom: 'Brt',
            bSort: false,
        });
    </script>

    <script>
        function tampilProduk(title = 'Pilih Produk') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
        }

        function pilihProduk(id, nama) {
            $('#produk_id').val(id);
            $('#nama_produk').val(nama);
            hideProduk();
            tambahProduk(nama);
            $('.btn-simpan').prop('disabled', false);
        }

        function tambahProduk(nama) {
            $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
                .done(response => {
                    if (response.status = 200) {
                        table1.ajax.reload();
                        table2.ajax.reload();
                        $('#nama_produk').focus();
                    }
                })
                .fail(errors => {
                    table1.ajax.reload();
                    table2.ajax.reload();
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps! Gagal',
                            text: errors.responseJSON.message,
                            showConfirmButton: true,
                        });
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }

                    $('#nama_produk').focus();
                    $('#nama_produk').val(nama);
                });

        }

        function hideProduk() {
            $(modal).modal('hide');
        }

        function tambahPelanggan(url, title = 'Pilih Pelanggan') {
            $(modalTambahPelanggan).modal('show');
            $(`${modalTambahPelanggan} .modal-title`).text(title);
            $(`${modalTambahPelanggan} form`).attr('action', url);
            $(`${modalTambahPelanggan} [name=_method]`).val('POST');
            $('#spinner-border').hide();

            $(button).show();
            $(button).prop('disabled', false);

            resetForm(`${modal} form`);
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
                    $(modalTambahPelanggan).modal('hide');
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

                            table3.ajax.reload();
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

        function tampilPelanggan(title = 'Pilih Pelanggan') {
            $(modalPelanggan).modal('show');
            $(`${modalPelanggan} .modal-title`).text(title);
        }

        function resetMember() {
            $('#member').val('');
            $('#nama_toko').val('');
            $('#diterima').val(0).focus().select();
            hidePelanggan();
        }

        function pilihPelanggan(id, kode) {
            $('#member').val(id);
            $('#kode_member').val(kode);
            $('#diterima').val(0).focus().select();
            hidePelanggan();
        }

        function hidePelanggan() {
            $(modalMember).modal('hide');
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
                                    table1.ajax.reload();
                                    table2.ajax.reload();
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
                                table1.ajax.reload();
                                table2.ajax.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>

    <script>
        function loadForm(diskon, diterima = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('transaksi/loadform') }}/${diskon}/${$('#total').val()}/${diterima}`)
                .done(response => {
                    $('#totalrp').val('Rp. ' + response.totalrp);
                    $('#bayarrp').val('Rp. ' + response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Bayar : Rp. ' + response.bayarrp);
                    $('.tampil-terbilang').text(response.terbilang)

                    $('#kembali').val('Rp. ' + response.kembalirp);
                    if ($('#diterima').val() != 0) {
                        $('.tampil-bayar').text('Kembali: Rp. ' + response.kembalirp);
                        $('.tampil-terbilang').text(response.kembali_terbilang);
                    }

                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: 'Tidak dapat menampilkan data',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return;
                });
        }
    </script>
@endpush
