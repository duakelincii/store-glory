@extends('theme.theme')
@section('title', 'Beli Sayur')
@section('content')
    {{-- Slider --}}
    <div id="slider" class="my-3">
        <div class="swiper-container h-36 md:h-64">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @foreach ($banners as $data )
                        @if ($data->is_active == 1)
                            <div class="swiper-slide">
                                <img src="{{ asset($data->gambar) }}" class="object-cover h-36 md:h-64 w-full rounded"
                                    alt="">
                            </div>
                        @endif
                @endforeach
            </div>
        </div>
    </div>
    {{-- End of Slider --}}


    <h1 class="text-md text-dark font-semibold border-b-2 pb-3">Beli Sekarang!</h1>
    <div class="my-3 grid grid-flow-row grid-cols-1 md:grid-cols-3 gap-4 auto-rows-max">
        @foreach ($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <div class="modal-body">
                <div id="page" class="p-2"></div>
            </div>
        </div>
    </div>
</div>
{{-- End of Modal --}}

@endsection
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
@endsection
@section('js')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            autoplay: true,
            delay: 2000,
        });
    </script>
@endsection
