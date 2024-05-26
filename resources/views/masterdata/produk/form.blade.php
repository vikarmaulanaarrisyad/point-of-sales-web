<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-6 col-6">
            <div class="form-group">
                <label for="barcode">Kode Produk</label>
                <input type="text" class="form-control" name="barcode" id="barcode" autocomplete="off">
            </div>
        </div>
        <div class="col-md-6 col-6">
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" class="form-control" name="nama_produk" id="nama_produk" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-6">
            <div class="form-group">
                <label for="satuan">Satuan</label>
                <select name="satuan" id="satuan" class="form-control select2"></select>
            </div>
        </div>
        <div class="col-md-6 col-6">
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori" class="form-control select2"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control" value="0" min="0">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="harga_beli">Harga Beli</label>
                <input type="text" name="harga_beli" id="harga_beli" class="form-control" min="0"
                    onkeyup="format_uang(this)">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="harga_jual">Harga Jual</label>
                <input type="text" name="harga_jual" id="harga_jual" class="form-control" min="0"
                    onkeyup="format_uang(this)">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="image">Gambar</label>
                <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input" id="image"
                        onchange="preview('.preview-image', this.files[0])">
                    <label class="custom-file-label" for="image">Choose file</label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <img src="" class="img-thumbnail preview-image"
                    style="display: none; width: 100%; height: 50%;">
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
