<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="">Nama Role</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama role"
                    autocomplete="off">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <p>SELECT PERMISSIONS</p>
        </div>
    </div>
    {{--
    @if ($permissionGroups->count())
        <div class="row">
            @foreach ($permissionGroups as $permissionGroup)
                <div class="col-lg-4 col-md-4 col-4 mb-4">
                    <div class="form-check">
                        <h5>{{ $permissionGroup->name }}</h5>
                        @if ($permissionGroup->permissions->count())
                            @foreach ($permissionGroup->permissions as $permission)
                                <input value="{{ $permission->id }}" id="permission_ids_{{ $permission->id }}"
                                    class="form-check-input" type="checkbox" name="permission_ids[]">
                                <label for="permission_ids_{{ $permission->id }}"
                                    class="form-check-label">{{ $permission->name }}</label>
                                <br>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif  --}}

    {{--  <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Config</th>
                        <th>Menu</th>
                        <th colspan="8">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Baris Konfigurasi -->
                    <tr>
                        <td>Konfigurasi</td>
                        <td>Read</td>
                        <td colspan="8"></td>
                    </tr>
                    <!-- Sub-baris Menu -->
                    <tr>
                        <td style="padding-left: 50px">Menu</td>
                        <td>read</td>
                        <td>read</td>
                        <td>read</td>
                        <td>read</td>
                        <td>read</td>
                        <td>read</td>
                        <td>read</td>
                        <td>read</td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>  --}}

    <div class="row">
        <div class="col-md-12">
            <table class="table" style="width: 100%">
                <thead class="thead-light">
                    <tr>
                        <th>Nama</th>
                        <th>Action</th>
                        <th colspan="8"></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Baris Konfigurasi -->
                    <tr>
                        <td>Konfigurasi</td>
                        <td>Read</td>
                    </tr>
                    <!-- Sub-baris Menu -->
                    @foreach ($permissionGroups as $permissionGroup)
                        <tr>
                            <td>{{ $permissionGroup->name }}</td>
                            @foreach ($permissionGroup->permissions as $permission)
                                <td>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input"
                                                id="customSwitch_{{ $permission->id }}">
                                            <label class="custom-control-label"
                                                for="customSwitch_{{ $permission->id }}">Read</label>
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                            <td colspan="5"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-info" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
