<form action="{{route('admin.product.update',$item->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    {{-- @method('PATCH') --}}
    <div class="form-group mb-3">
        <label class="form-label">Produk <small class="text-danger">*</small></label>
        <input type="text" name="name" value="{{ $item->name }}" placeholder="Product"
            class="form-control">
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Harga <small class="text-danger">*</small></label>
        <input type="text" name="harga" value="{{ $item->harga }}" placeholder="Harga Product"
            class="form-control">
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Kategori <small class="text-danger">*</small></label>
        <select class="form-control select2" name="category_id" id="">
            @foreach ($category as $dataCategory)
                <option value="{{ $dataCategory->id }}">{{ $dataCategory->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="">Deskripsi</label>
        <textarea class="form-control" name="desc" id="" rows="3">{{$item->desc}}</textarea>
    </div>
    <div class="form-group">
        <label for="">Gambar</label>
        <input type="file" name="gambar" value="{{$item->gambar}}" accept="image/png,image/jpeg">
        <div class="px-2 py-3 rounded border text-secondary">
            <i class="fas fa-image"></i> Upload Gambar
        </div>
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
</form>
