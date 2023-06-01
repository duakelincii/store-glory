@extends('layouts.app',[
    'namePage' => 'Kelola Pengaturan',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'pengaturan',
    'backgroundImage' => asset('now') . "/img/bg14.jpg",
    'parent' => 'master'
])
@section('content')
    <script>
        function loadImgPreview(event) {
            var output = $(event.target).parent().find('img')[0];
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
<div class="panel-header panel-header-sm">

</div>
    <div class="row">
        <div class="col-12">
            <div class="card p-4">
                <form action="{{route('admin.settings.post')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th>Key</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nama Website</td>
                                <td>{{ $setting['name'] }}</td>
                                <td>
                                    <input class="form-control" type="text" name="name"
                                        value="{{ $setting['name'] }}">
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>No Handphone</td>
                                <td>{{ $setting['no_wa'] }}</td>
                                <td>
                                    <input class="form-control" type="text" name="no_wa"
                                        value="{{ $setting['no_wa'] }}">
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Logo Toko</td>
                                <td><img style="max-height: 400px;" src="{{ $setting['logo'] }}"></td>
                                <td>
                                    <img style="max-height: 400px;" id="icon-preview">
                                    <input class="form-control" type="file" name="logo"
                                        onchange="loadImgPreview(event)">
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <button class="btn btn-primary mt-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>

@endsection
