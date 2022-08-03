    <x-guest-layout>
        <x-slot name="title">
            {{ __('Pendaftaran Permohonan') }}
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
                                title: "Perhatian!",
                                text: val,
                                icon: "warning",
                            });
                        })
                    }
                    if ({{ Illuminate\Support\Js::from(session()->get('success')) }}) {
                        swal({
                            title: "Berhasil Menambahkan Data Pemohon",
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
            @include('layouts.navigation-guest')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid " style="margin-bottom: 300px">

                <!-- Page Heading -->
                <div class="text-center mb-4">
                    <h1 class="h3 mb-0 font-weight-bold text-gray-800">Formulir Perdaftaran</h1>
                    <div>
                        <span><small>Permohonan Pengukuran Bidang Tanah</small></span>
                    </div>
                    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
                </div>

                <!-- Content Row -->
                <form action="{{ route('PendaftaranStore') }}" method="post" >
                    @method('POST')
                    @csrf
                    <div class="row">
                        <div class="col-8 mx-auto card">
                            {{-- <div class="crad-header">
                                <h4>Formulir Pemilik Tanah Bidang</h4>
                            </div> --}}
                            <div class="card-body row">
                                <div class="col-12 my-2">
                                    <label for="">Nama Lengkap</label>
                                    <input type="text" id="nama_pemilik" name="nama_pemilik"
                                        class="form-control @error('nama_pemilik') is-invalid @enderror"
                                        value="{{ old('nama_pemilik') }}" placeholder="Nama Lengkap">
                                </div>

                                <div class="col-6 my-2">
                                    <label for="">Nomor Sertifikat</label>
                                    <input type="number" id="nomor_sertifikat" name="nomor_sertifikat"
                                        class="form-control @error('nomor_sertifikat') is-invalid @enderror"
                                        value="{{ old('nomor_sertifikat') }}" placeholder="Nomor Sertifikat">
                                </div>

                                <div class="col-6 my-2">
                                    <label for="">NIB <small>(Nomor Identifikasi Bidang Tanah)</small></label>
                                    <input type="number" id="nib" name="nib"
                                        class="form-control @error('nib') is-invalid @enderror"
                                        value="{{ old('nib') }}" placeholder="NIB">
                                </div>

                                <div class="col-12 my-2">
                                    <label for="">Kelurahana Desa</label>
                                    <select id="village_id" name="village_id"
                                        class="form-control @error('village_id') is-invalid @enderror">
                                        <option class="d-none" value="">Kosong</option>
                                        @foreach ($desa as $value)
                                            <option value="{{ $value->id }}"  @if (old('village_id') == $value->id)
                                                selected
                                            @endif>{{ $value->nama_desa }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6 my-2">
                                    <label for="">Nomor Telepon / HP</label>
                                    <input type="number" id="nomor_telpon" name="nomor_telpon"
                                        class="form-control @error('nomor_telpon') is-invalid @enderror"
                                        value="{{ old('nomor_telpon') }}" placeholder="Nomor Telepon">
                                </div>

                                <div class="col-6 my-2">
                                    <label for="">Nomor HAK</label>
                                    <input type="number" id="nomor_hak" name="nomor_hak"
                                        class="form-control @error('nomor_hak') is-invalid @enderror"
                                        value="{{ old('nomor_hak') }}" placeholder="Nomor HAK">
                                </div>

                                <div class="col-12 my-5 d-flex justify-content-end">
                                    <a href="{{ url('/') }}" class="btn btn-outline-primary mr-2">
                                        Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>

            </div>
            <!-- /.container-fluid -->

        </div>
    </x-guest-layout>
