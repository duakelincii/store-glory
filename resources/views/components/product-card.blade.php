<div class="w-full bg-white shadow-2xl rounded-md overflow-hidden">
    <div class="img">
        <a href="{{ url("detail/$product->id") }}">
            <img src="{{ asset($product->gambar) }}" alt="Foto Lapangan" class="object-cover w-full">
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

                </small>
            </p>
            {{-- <p class="text-gray-500">
                <i class="fas fa-xs fa-ruler-combined"></i>
                <small class="font-light">
                    {{ $product->witdh }}m x {{ $product->height }}m
                </small>
            </p> --}}
        </div>
    </div>
    <div class="footer px-2 py-2 flex justify-end border-t-1 space-x-2">
        {{-- <a href="{{url("detail/$product->id")}}" class="px-3 py-2 w-full font-semibold text-xs text-center rounded-md transition duration-500
             bg-white border border-primary hover:bg-primary text-primary hover:text-white">
            Cek Jadwal
        </a> --}}
        <a href="{{ url("detail/$product->id") }}"
            class="px-3 py-2 w-full font-semibold text-xs text-center rounded-md transition duration-500
             bg-secondary hover:bg-primary text-primary hover:text-white">
            Tambahkan Ke keranjang
        </a>
    </div>
</div>
