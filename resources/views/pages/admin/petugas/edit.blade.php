    <x-app-layout>
        <x-slot name="title">
            {{ __('Dashboard') }}
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
                                title: "Warning",
                                text: val,
                                icon: "warning",
                            });
                        })

                    }
                    if ({{ Illuminate\Support\Js::from(session()->get('success')) }}) {
                        swal({
                            title: "Good Job",
                            text: {{ Illuminate\Support\Js::from(session()->get('success')) }},
                            icon: "success",
                        });
                        {{ Illuminate\Support\Js::from(session()->forget('success')) }}
                    }
                });
            </script>
        </x-slot>
        <div id="content">

            <!-- Topbar -->
            @include('layouts.navbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Formulir Penambahan Data Tanah</h1>
                    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
                </div>

                @if ($errors->any())
                    <div class="mb-3">
                        <div class="text-danger">
                            {{ __('Whoops! Something went wrong.') }}
                        </div>

                        <ul class="text-danger-600">
                            @foreach ($errors->all() as $error)
                                <li class="text-danger"><small>{{ $error }}</small></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Content Row -->
                <form action="{{ route('operatorStaffUpdate', ['id' => $staff->id]) }}" method="post">
                    @method('POST')
                    @csrf
                    <div class="row">

                        <div class="col-12 my-1">
                            <label for="">Nama</label>
                            <select name="id" id="id" class="form-control">
                                @foreach ($guestLands as $guestLand)
                                    <option value="{{ $guestLand->id }}">
                                        {{ $guestLand->nib }} <small>{{ $guestLand->nama_pemilik }}</small>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 my-5 d-flex justify-content-end">
                            <a href="{{ route('operatorStaff') }}" class="btn btn-outline-primary mr-2">
                                Back
                            </a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </form>

            </div>
            <!-- /.container-fluid -->

        </div>
    </x-app-layout>
