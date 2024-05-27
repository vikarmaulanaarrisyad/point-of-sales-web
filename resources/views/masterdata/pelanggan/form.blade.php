<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-4 col-4">
            <div class="form-group">
                <label for="nama_toko">Nama Toko</label>
                <input type="text" class="form-control" name="nama_toko" id="nama_toko" autocomplete="off">
            </div>
        </div>
        <div class="col-md-4 col-4">
            <div class="form-group">
                <label for="nama_pemilik">Nama Pemilik Toko</label>
                <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" autocomplete="off">
            </div>
        </div>
        <div class="col-md-4 col-4">
            <div class="form-group">
                <label for="nomor_hp">Nomor Hp</label>
                <input type="text" class="form-control" name="nomor_hp" id="nomor_hp" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" cols="30" rows="4" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-danger" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
