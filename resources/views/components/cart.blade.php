<form action="{{route('cart.simpan',$item->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- @method('put') --}}
    <div class="p2">
        <div class="form-group">
            <label for="">Nama Product</label>
            <input type="text" name="name" value="{{$item->name}}"  class="form-control">
        </div>
        <div class="form-group">
            <label for="">Quantity</label>
            <input type="number" name="qty" class="form-control">
        </div>
        <div class="form-group mt-2">
            <button class="btn btn-primary mb-2">Simpan</button>
            <a href="{{route('app')}}" class="px-3 py-2 w-full font-semibold text-xs text-center rounded-md transition duration-500
            bg-secondary block hover:bg-primary text-primary hover:text-white">Batal</a>
        </div>
    </div>
</form>
