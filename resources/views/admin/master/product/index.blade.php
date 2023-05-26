@extends('layouts.app', [
    'namePage' => 'Kelola Product',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'product',
    'backgroundImage' => asset('now') . '/img/bg14.jpg',
    'parent' => 'master',
])
@section('title', 'Product')
@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="card-title">
                                Kelola Product
                            </div>
                            <a href="#" data-toggle="modal" data-target="#modalCreate"
                                class="btn btn-round btn-primary">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="form-group">
                                <input type="text" name="q" value="{{ request()->q }}" placeholder="Cari"
                                    class="form-control form-control-md">

                            </div>
                        </form>
                        <div class="d-flex justify-content-between">
                            <p class="mt-3">
                                Hasil : {{ $products->count() }}
                            </p>
                            <div>
                                <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Reset</a>
                                <button class="btn btn-info">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">{{ $products->links('pagination::bootstrap-4') }}</div>
                    @foreach ($products as $data)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title h4 text-center">{{ $data->name }}</h2>
                                    <img src="{{ asset($data->gambar) }}" alt="" class="img"
                                        style="object-fit:cover;width:100%;max-height:150px">
                                </div>
                                <div class="card-body description-box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">Kategori</p>
                                        <p class="text-muted">{{ $data->category->name }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">Deskripsi</p>
                                        <p class="text-muted">{{ $data->desc }}</p>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <button type="button" data-id="{{ $data->id }}"
                                        class="btn btn-info btn-round w-100 mr-2 btn-edit">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" data-id="{{ $data->id }}"
                                        class="btn btn-danger btn-round w-100 btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-12">{{ $products->links('pagination::bootstrap-4') }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modal')
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.product.store') }}" method="post" id="formCreate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Produk <small class="text-danger">*</small></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Product"
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
                            <textarea class="form-control" name="desc" id="" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Gambar</label>
                            <input type="file" name="gambar" class="d-none" id="gambar">
                            <div class="px-2 py-3 rounded border text-secondary upload-image" data-target="#gambar">
                                <i class="fas fa-image"></i> Upload Gambar
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal"
                                aria-label="Close">
                                Tutup
                            </button>
                            <button type="reset" class="d-none"></button>
                            <button type="submit" class="btn btn-info btn-round">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formEdit">
                        @csrf
                        @method('PATCH')
                        <div class="form-group mb-3">
                            <label class="form-label">Produk <small class="text-danger">*</small></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Product"
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
                            <textarea class="form-control" name="desc" id="" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Gambar</label>
                            <input type="file" name="gambar" class="d-none" id="gambar">
                            <div class="px-2 py-3 rounded border text-secondary upload-image" data-target="#gambar">
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
                </div>
            </div>
        </div>
    </div>
@endpush
@push('js')
    <script>
        $(document).ready(function() {

            //Upload Image
            $('.upload-image').click(function() {
                const target = $(this).data('target');
                $(target).click();
            })

            $('input[name="img"]').change(function() {
                let images = ``;
                const files = document.querySelector('input[name="gambar"]').files;
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    images +=
                        `<span class="badge badge-info">${file?.name?.split(/(\\|\/)/g).pop()+'\n'}</span>,`;
                }
                if (images == ``) {
                    images = `<i class="fas fa-image"></i> Upload Gambar`;
                }
                $('.upload-image[data-target="#gambar"]').html(images);
            })

            $('.btn-edit').click(function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `{{ url('api/json/product') }}/${id}`,
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        if (data?.success) {
                            const product = data?.data;
                            const formEdit = $('#formEdit');
                            formEdit.attr('action',
                                `{{ route('admin.product.store') }}/update/${product?.id}`);
                            formEdit.find("input[name='name']").val(product?.name);
                            formEdit.find("input[name='desc']").val(product?.desc);
                            formEdit.find(
                                `input[name='category_id'][value='${product?.category_id}']`
                            ).prop('selected', true);
                            return $('#modalEdit').modal('show');
                        }
                        return toastr("error", "Invalid Error! Try again later");
                    },
                    error: function(xhr, status, err) {
                        return toastr("error", `${err.toString()}`);
                    }
                })
            });
            $('.btn-delete').click(function() {
                const id = $(this).data('id');
                return confirmDelete(`Anda yakin ingin menghapus Product?`, function() {
                    $.ajax({
                        url: `{{ route('admin.product.store') }}/delete/${id}`,
                        type: 'DELETE',
                        dataType: 'json',
                        data: $(this).serialize(),
                        success: function(data) {
                            if (data?.success) {
                                toastr("success", data?.message);
                                return setTimeout(() => {
                                    window.location.reload();
                                }, 800);
                            }
                            return toastr("error", "Undefined Error!");
                        },
                        error: function(xhr, status, err) {
                            return toastr("error", err.toString());
                        }
                    })
                });
            })
        })
    </script>
@endpush
