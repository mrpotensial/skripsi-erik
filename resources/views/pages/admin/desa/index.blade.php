<x-app-layout>
    <x-slot name="title">
        {{ __('Admin | Desa') }}
    </x-slot>
    <x-slot name="headerLink">
        <!-- Custom styles for this page -->
        <link href="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
            integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
            crossorigin="" />
        <style>
            #map,
            #mapLayout {
                height: 600px;
            }
        </style>
    </x-slot>
    <x-slot name="footerScript">
        <!-- Page level plugins -->
        <script src="{{ asset('assets') }}/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('assets') }}/js/demo/datatables-demo.js"></script>

        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
                integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
                crossorigin=""></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            $(document).ready(function() {

                if ({{ Illuminate\Support\Js::from($errors->any()) }}) {

                    $({{ Illuminate\Support\Js::from($errors->all()) }}).each(function(i, val) {
                        swal({
                            title: "Perhatian",
                            text: val,
                            icon: "warning",
                        });
                    })

                }
                if ({{ Illuminate\Support\Js::from(session()->get('success')) }}) {
                    swal({
                        title: "Berhasil",
                        text: {{ Illuminate\Support\Js::from(session()->get('success')) }},
                        icon: "success",
                    });
                    {{ Illuminate\Support\Js::from(session()->forget('success')) }}
                }
                if ({{ Illuminate\Support\Js::from(session()->get('warning')) }}) {
                    swal({
                        title: "Oops?",
                        text: {{ Illuminate\Support\Js::from(session()->get('warning')) }},
                        icon: "warning",
                    });
                    {{ Illuminate\Support\Js::from(session()->forget('warning')) }}
                }

            });
        </script>
    </x-slot>
    <div id="content">

        @include('layouts.navbar')

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            {{-- <h1 class="h3 mb-2 text-gray-800">Daftar Data Desa</h1> --}}
            {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                For more information about DataTables, please visit the <a target="_blank"
                    href="https://datatables.net">official DataTables documentation</a>.</p> --}}

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}
                    <div class="row">
                        <div class="col-9">
                            <h1 class="h3 mb-2 text-gray-800">Daftar Data Desa</h1>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('adminDesaCreate') }}" class="btn btn-icon btn-sm btn-primary"><i
                                        class="fas fa-plus mr-1"></i> Tambah Desa</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Desa</th>
                                    <th>Nama Kecamatan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nama Desa</th>
                                    <th>Nama Kecamatan</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (count($desa) > 0)
                                    @foreach ($desa as $index => $value)
                                        <tr class="m-auto p-auto align-middle">
                                            <td>{{ $value->nama_desa }}</td>
                                            <td>{{ $value->district->nama_kecamatan }}</td>
                                            <td class="d-flex justify-content-end">
                                                <div>
                                                    <a class="btn btn-icon btn-primary btn-sm my-1"
                                                        href="{{ route('adminDesaShow', ['id' => $value->id]) }}"><i
                                                            class="fas fa-eye mr-1"></i>Lihat</a>
                                                    <a class="btn btn-icon btn-warning btn-sm my-1"
                                                        href="{{ route('adminDesaEdit', ['id' => $value->id]) }}"><i
                                                            class="fas fa-edit mr-1"></i>Ubah</a>
                                                    <button type="button" class="btn btn-icon btn-danger btn-sm my-1" data-toggle="modal" data-target="#desa{{$index}}">
                                                        <i class="fas fa-trash mr-1"></i>Hapus
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="desa{{$index}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Desa {{$value->nama_desa}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah anda yakin ingin mengahapus data ini?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Batal</button>
                                                                <a class="btn btn-icon btn-danger btn-sm my-1"
                                                                     href="{{ route('adminDesaDestroy', ['id' => $value->id]) }}"><i class="fas fa-trash mr-1"></i>Hapus</a>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">
                                            Data Kosong
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
</x-app-layout>
