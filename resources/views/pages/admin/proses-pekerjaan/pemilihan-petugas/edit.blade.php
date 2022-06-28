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

                <!-- Content Row -->
                <form action="{{ route('adminPemilihanPetugasUpdate', ['id' => $guestLand->id]) }}" method="post">
                    @method('POST')
                    @csrf
                    <div class="row">

                        <div class="col-12">
                            <div class="card shadow border border-secondary mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-secondary">Detail Data</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Nama Pemilik</td>
                                                <td>{{ $guestLand->nama_pemilik }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Sertifikat</td>
                                                <td>{{ $guestLand->nomor_sertifikat }}</td>
                                            </tr>
                                            <tr>
                                                <td>NIB</td>
                                                <td>{{ $guestLand->nib }}</td>
                                            </tr>
                                            <tr>
                                                <td>Desa</td>
                                                <td>{{ $guestLand->village->nama_desa }}</td>
                                            </tr>
                                            <tr>
                                                <td>Kecamatan</td>
                                                <td>{{ $guestLand->village->district->nama_kecamatan }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Telp</td>
                                                <td>{{ $guestLand->nomor_telpon }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 card">
                            <div class="card-header">
                                <h4>Pemilihan Petugas</h4>
                                <small>Kosongkan Jika Belum dapat ditetapkan</small>
                            </div>
                            <div class="card-body row">
                                <div class="col-6 my-1">
                                    <label for="">Pilih Petugas</label>
                                    <select id="petugas" name="petugas"
                                        class="form-control @error('petugas') is-invalid @enderror">
                                        <option class="d-none" value="" selected>Kosong</option>
                                        @foreach ($petugas as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6 my-1">
                                    <label for="">Update Batas Waktu Penerimaan Pekerjaan</label>
                                    <input type="date" id="batas_waktu_pekerjaan" name="batas_waktu_pekerjaan"
                                        class="form-control @error('batas_waktu_pekerjaan') is-invalid @enderror">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 my-5 d-flex justify-content-end">
                            <a href="{{ route('adminPemilihanPetugas') }}" class="btn btn-outline-primary mr-2">
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
