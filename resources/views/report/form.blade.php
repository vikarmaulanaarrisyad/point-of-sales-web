<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="jabatan">Tanggal Awal</label>
                <div class="input-group datepicker" id="start" data-target-input="nearest">
                    <input type="text" name="start" class="form-control datetimepicker-input" data-target="#start"
                        data-toggle="datetimepicker" autocomplete="off">
                    <div class="input-group-append" data-target="#start" data-toggle="datetimepicker">
                        <div class="input-group-text">
                            <i class="fa fa-calendar">

                            </i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="jabatan">Tanggal Selesai</label>
                <div class="input-group datepicker" id="end" data-target-input="nearest">
                    <input type="text" name="end" class="form-control datetimepicker-input" data-target="#end"
                        data-toggle="datetimepicker" autocomplete="off">
                    <div class="input-group-append" data-target="#end" data-toggle="datetimepicker">
                        <div class="input-group-text">
                            <i class="fa fa-calendar">
                            </i>
                        </div>
                    </div>
                </div>
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
