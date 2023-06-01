<div class="w-full bg-white shadow-2xl rounded-md overflow-hidden">
    <div class="img">
        <a href="{{ url("detail/$product->id") }}">
            <img src="{{ asset($product->gambar) }}"  class="object-cover w-full">
        </a>
    </div>
    <div class="description px-2 py-4">
        <a href="{{ url("detail/$product->id") }}">
            <h2 class="text-dark font-medium text-xl">
                {{ $product->name }}
            </h2>
        </a>
        <div class="caption flex justify-between align-middle items-center">
            <p class="text-gray-600">
                <i class="fas fa-xs fa-money-bill-wave"></i>
                <small class="font-light">
                    @rupiah($product->harga)
                </small>
            </p>
        </div>
    </div>
    <div class="footer px-2 py-2 flex justify-end border-t-1 space-x-2">
        <a href="#" class="px-3 py-2 w-full font-semibold text-xs text-center rounded-md transition duration-500
        bg-secondary hover:bg-primary text-primary hover:text-white" onclick="return edit({{ $product->id }})">Tambah Ke Keranjang</a>
        {{-- <form action="{{route('cart.simpan',$product->id)}}" method="POST">
            @csrf
            <button class="px-3 py-2 w-full font-semibold text-xs text-center rounded-md transition duration-500
            bg-secondary hover:bg-primary text-primary hover:text-white">Tambah Ke Keranjang</button>
        </form> --}}
        {{-- <a href="{{ route('cart.simpan',$product->id) }}"
            class="px-3 py-2 w-full font-semibold text-xs text-center rounded-md transition duration-500
             bg-secondary hover:bg-primary text-primary hover:text-white">
            Tambahkan Ke keranjang
        </a> --}}
    </div>
</div>
@section('js')
    <script>
        function edit(id) {
            $.get("{{ url('cart/tambah/keranjang') }}/" + id , {}, function(data, status) {
                $("#exampleModalLabel").html('Tambah Keranjang')
                $("#page").html(data);
                $("#exampleModal").modal('show');
                CKEDITOR.replace( 'desc' );
            });
        }
    </script>
@endsection
