<form action="{{route('admin.banner.update',$item->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    {{-- @method('PATCH') --}}
    <div class="p-2">
        <div class="form-group mb-3">
            <label class="form-label">Name <small class="text-danger">*</small></label>
            <input type="text" name="title" value="{{ $item->title }}" placeholder="Banner"
                class="form-control">
        </div>
        <div class="form-group">
            <label for="">Gambar</label>
            <input type="file" name="gambar" accept="image/png,image/jpeg">
            <div class="px-2 py-3 rounded border text-secondary" >
                <i class="fas fa-image"></i> Upload Gambar
            </div>
        </div>
        <div class="form-group mb-3">
            <input type="checkbox" name="is_active" value="{{$item->is_active}}" >
            <label for="">Active</label>
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal"
                aria-label="Close">
                Tutup
            </button>
            <button type="reset" class="d-none"></button>
            <button type="submit" class="btn btn-info btn-round" id="btnSave">
                Simpan Perubahan
            </button>
        </div>
    </div>
</form>
