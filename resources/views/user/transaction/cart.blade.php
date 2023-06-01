@extends('theme.theme')
@section('title','Keranjang')
@section('content')
    <h1 class="text-md text-dark font-semibold border-b-2 pb-3">Beli Sekarang!</h1>
    <div class="my-3 grid grid-flow-row grid-cols-1 md:grid-cols-3 gap-4 auto-rows-max">
            @foreach ($cart as $data)
            <div class="w-full bg-white shadow-2xl rounded-md overflow-hidden">
                <div class="img">
                    <a href="#">
                        <img src="{{$data->product->gambar}}" width="20%" class="object-cover w-full">
                    </a>
                </div>
                <div class="description px-2 py-4">
                    <a href="#">
                        <h2 class="text-dark font-medium text-xl">
                            {{ $data->product->name }}
                        </h2>
                    </a>
                    <div class="caption flex justify-between align-middle items-center">
                        {{-- <input rowId="{{ $data->product_id }}" type="number" value="{{ $data->qty }}" class="form-control prc" required> --}}
                        <input type="hidden" rowId="{{ $data->product_id }}" name="product_id" id="product_id" value="{{$data->product->id}}" style="display:none">
                        <input class="cart-plus-minus-box qty" rowId="{{ $data->product_id }}" type="number" id="qty" class="qty" value="{{$data->qty}}" name="qty" value="1" >
                    </div>
                </div>
                <div class="footer px-2 py-2 flex justify-end border-t-1 space-x-2">
                    <a href="#" class="px-3 py-2 w-full font-semibold text-xs text-center rounded-md transition duration-500
                    bg-secondary block hover:bg-primary text-primary hover:text-white" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $data->product_id }}').submit();" >Hapus Dari Keranjang</a>
                </div>
                <form action="{{ route('delete.cart',$data->product_id) }}" method="POST" id="delete-form-{{ $data->product_id }}" style="display: none;">
                        {{csrf_field()}}
                        {{ method_field('DELETE') }}
                        <input type="hidden" value="{{ $data->product_id }}" name="user_id">
                </form>
            </div>
            @endforeach
        </div>
        @php
            $total = 0;
            foreach($cart as $data){
                $total += $data->product->harga * $data->qty;
            }
        @endphp
        @if ($cart->isNotEmpty())
            <a href="https://wa.me/{{$setting->no_wa}}?text=Halo%20{{Auth::user()->name}}%20Selamat%20Datang%20Di%20Store%20Sultan%20Sayur%0ABerikut%20Adalah%20Pesanan%20Anda%3A%0A  @foreach ($cart as $data) -%20{{$data->product->name}} : {{$data->qty}}pcs%0A @endforeach Total+Belanja+%3A+@rupiah($total)+%2C+Mohon+Konfirmasi"
                class="px-3 py-2 w-full font-semibold text-xs text-center rounded-md transition duration-500
                bg-secondary block hover:bg-primary text-primary hover:text-white" >
                Proses Transaksi
            </a>
        @endif
@endsection
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
@endsection
@section('js')
    <script>
        $( document ).ready(function() {
            $(".qty").change(function(e){
                e.preventDefault();
                var qty = e.target;
                var id = $(this).attr('rowId');
                var selct_ = $(this) //declare this
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                    $.ajax({
                    url: "{{ route('checkout.qty') }}",
                    data:{
                            'product_id': id,
                            'quantity':qty.value
                    },
                    type: "get",
                    success: function(result){
                    return back;
                }
                });
            });
        });

        $(document).on('click','.remove_item', function () {
            var id = $(this).data('id');
            $.ajax({
                    type: 'DELETE',
                    url: "cart/"+ id,
                    data: {'_token': $('meta[name=csrf-token]').val()},
                    success: function (data) {
                    $('#cart_product').html(data);
                    }
                });
       });
    </script>
@endsection
