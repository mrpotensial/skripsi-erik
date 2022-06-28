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
                    <h1 class="h3 mb-0 text-gray-800">Formulir Penambahan Data User</h1>
                    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
                </div>

                <!-- Content Row -->
                <form method="POST" action="{{ route('adminUserStore') }}">
                    @csrf
                    <!-- Name -->
                    <div class="col-12 card">
                        <div class="crad-header">
                            <h4>Data User Baru</h4>
                        </div>
                        <div class="card-body row">
                            <div class="col-12 my-1">
                                <label for="">Nama</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required autofocus>
                            </div>

                            <div class="col-12 my-1">
                                <label for="">Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required>
                            </div>

                            <div class="col-6 my-1">
                                <label for="">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required
                                    autocomplete="new-password">
                            </div>

                            <div class="col-6 my-1">
                                <label for="">Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" required>
                            </div>

                            <div class="col-6 my-1">
                                <label for="">Level User</label>
                                <select name="level" id="level" class="form-control" required>
                                    <option value="0">Admin</option>
                                    <option value="1">Petugas</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 my-5 d-flex justify-content-end">
                        <a href="{{ route('adminUser', ['select' => 'all']) }}" class="btn btn-outline-primary mr-2">
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.container-fluid -->

        </div>
    </x-app-layout>
