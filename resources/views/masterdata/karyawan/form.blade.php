<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-6 col-6">
            <div class="form-group">
                <label for="nama_karyawan">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama_karyawan" id="nama_karyawan"
                    placeholder="Masukkan nama karyawan" autocomplete="off">
            </div>
        </div>
        <div class="col-md-6 col-6">
            <div class="form-group">
                <label for="nik_karyawan">Nomor NIK Karyawan</label>
                <input type="text" class="form-control" name="nik_karyawan" id="nik_karyawan"
                    placeholder="Masukkan NIK karyawan" autocomplete="off">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-4">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Masukkan email"
                    autocomplete="off">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                    placeholder="Masukkan tempat lahir karyawan" autocomplete="off">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="tgl_lahir_karyawan">Tanggal Lahir</label>
                <div class="input-group datepicker" id="tgl_lahir_karyawan" data-target-input="nearest">
                    <input type="text" name="tgl_lahir_karyawan" class="form-control datetimepicker-input"
                        data-target="#tgl_lahir_karyawan" autocomplete="off" placeholder="Masukkan tanggal lahir" />
                    <div class="input-group-append" data-target="#tgl_lahir_karyawan" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="alamat">Jenis Kelamin</label>
                <select name="jenis_kelamin_karyawan" id="jenis_kelamin_karyawan" class="form-control">
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="no_telp_karyawan">Nomor Telepon</label>
                <input type="text" class="form-control" name="no_telp_karyawan" id="no_telp_karyawan"
                    placeholder="Masukkan nomor telepon" autocomplete="off">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <select name="jabatan" id="jabatan" class="form-control">
                    <option value="" disabled selected>Pilih Jabatan</option>
                    @foreach ($jabatan as $item)
                        <option value="{{ $item->id }}">{{ $item->jabatan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <textarea name="alamat_karyawan" id="alamat_karyawan" cols="30" rows="4" class="form-control"
                    placeholder="Masukkan alamat karyawan"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="target_penjualan_bulan">Target Penjualan Perbulan</label>
                <input type="text" name="target_penjualan_bulan" id="target_penjualan_bulan" class="form-control"
                    value="0" onkeyup="format_uang(this)" min="0">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="target_penjualan_harian">Target Penjualan Perhari</label>
                <input type="text" name="target_penjualan_harian" id="target_penjualan_harian"
                    class="form-control" value="0" onkeyup="format_uang(this)" min="0">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="photo">Gambar</label>
                <div class="custom-file">
                    <input type="file" name="photo" class="custom-file-input" id="photo"
                        onchange="preview('.preview-photo', this.files[0])">
                    <label class="custom-file-label" for="photo">Choose file</label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <img src="" class="img-thumbnail preview-photo"
                    style="display: none; width: 150px; height: 190px;">
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-info" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status"
                aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
