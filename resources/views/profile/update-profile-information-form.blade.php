<form action="{{ route('user-profile-information.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <x-card>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="text-center">
                    @if (!empty(auth()->user()->path_image) && Storage::disk('public')->exists(auth()->user()->path_image))
                        <img src="{{ Storage::url(auth()->user()->path_image) }}" alt=""
                            class="img-thumbnail preview-path_image" width="200">
                    @else
                        <img src="{{ asset('AdminLTE/dist/img/user1-128x128.jpg') }}" alt=""
                            class="img-thumbnail preview-path_image" width="200">
                    @endif

                </div>
                <div class="form-group mt-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="path_image" name="path_image"
                            onchange="preview('.preview-path_image', this.files[0])">
                        <label class="custom-file-label" for="path_image">Choose file</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" value="{{ old('name') ?? auth()->user()->name }}">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        id="email" value="{{ old('email') ?? auth()->user()->email }}">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{--  <div class="col-lg-4">
                <label for="role">Role</label>
                <input type="text" class="form-control @error('role') is-invalid @enderror" name="role"
                    id="role" value="{{ old('role') ?? auth()->user()->role->name }}" disabled>
                @error('role')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>  --}}
        </div>

        <x-slot name="footer">
            <button type="reset" class="btn btn-dark">Reset</button>
            <button class="btn btn-primary">Simpan</button>
        </x-slot>
    </x-card>
</form>

@includeIf('includes.datepicker')
