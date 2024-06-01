<x-modal class="modal-pelanggan" data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-12">
            <x-table class="table-pelanggan">
                <x-slot name="thead">
                    <th>No</th>
                    <th>Nama Toko</th>
                    <th>Alamat Member</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </x-slot>
            </x-table>
        </div>
    </div>
</x-modal>
