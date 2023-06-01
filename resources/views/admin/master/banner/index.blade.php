@extends('layouts.app', [
    'namePage' => 'Kelola Banner',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'banner',
    'backgroundImage' => asset('now') . '/img/bg14.jpg',
    'parent' => 'master',
])
@section('title', 'Banner')
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
                                Kelola Banner
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
                                Hasil : {{ $banners->count() }}
                            </p>
                            <div>
                                <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary">Reset</a>
                                <button class="btn btn-info">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">{{ $banners->links('pagination::bootstrap-4') }}</div>
                    @foreach ($banners as $data)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title h4 text-center">{{ $data->name }}</h2>
                                    <img src="{{ asset($data->gambar) }}" alt="" class="img"
                                        style="object-fit:cover;width:100%;max-height:150px">
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
                    <div class="col-md-12">{{ $banners->links('pagination::bootstrap-4') }}</div>
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
                    <h5 class="modal-title">Tambah Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.banner.store') }}" method="post" id="formCreate"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Name<small class="text-danger">*</small></label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Banner"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Gambar</label>
                            <input type="file" name="gambar" class="d-none" id="gambar" accept="image/png,image/jpeg">
                            <div class="px-2 py-3 rounded border text-secondary upload-image" data-target="#gambar">
                                <i class="fas fa-image"></i> Upload Gambar
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <input type="checkbox" name="is_active" value="1" >
                            <label for="">Active</label>
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
                    <h5 class="modal-title">Edit Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formEdit">
                        @csrf
                        @method('PATCH')
                        <div class="form-group mb-3">
                            <label class="form-label">Name <small class="text-danger">*</small></label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Banner"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Gambar</label>
                            <input type="file" name="gambar" class="d-none" id="gambar">
                            <div class="px-2 py-3 rounded border text-secondary upload-image" data-target="#gambar">
                                <i class="fas fa-image"></i> Upload Gambar
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <input type="checkbox" name="is_active" value="{{old('is_active')}}" >
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
                    url: `{{ url('api/json/banner') }}/${id}`,
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        if (data?.success) {
                            const banner = data?.data;
                            const formEdit = $('#formEdit');
                            formEdit.attr('action',
                                `{{ route('admin.banner.store') }}/update/${banner?.id}`);
                            formEdit.find("input[name='title']").val(banner?.title);
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
                return confirmDelete(`Anda yakin ingin menghapus banner?`, function() {
                    $.ajax({
                        url: `{{ route('admin.banner.store') }}/delete/${id}`,
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
