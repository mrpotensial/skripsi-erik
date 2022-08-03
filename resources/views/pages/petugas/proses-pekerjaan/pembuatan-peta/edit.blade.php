    <x-app-layout>
        <x-slot name="title">
            {{ __('Pembuatan Peta') }}
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
                                title: "Peringatan",
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

                });
                const lat = $('#lat').val();
                const lng = $('#lng').val();
                const zoom = $('#zoom').val();
                var map = L.map('map').setView([lat, lng], zoom);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                var popup = L.popup();

                function onMapClick(e) {
                    popup
                        .setLatLng(e.latlng)
                        .setContent("You clicked the map at " + e.latlng.toString())
                        .openOn(map);
                }

                map.on('click', onMapClick);

                $('#cariData').click(function() {
                    // $('#mapLayout').html('<div id="map" name="map"></div>');
                    alert($('#invoice').val());
                    lat = $('#lat').val();
                    lng = $('#lng').val();
                })



                // $(document.ready(function() {}))
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
                    <h1 class="h3 mb-0 text-gray-800">Formulir Upload Data Tanah </h1>
                    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
                </div>

                <!-- Content Row -->
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('petugasPembuatanPetaUpdate', ['id' => $guestLand->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="row">

                                <div class="col-12 my-1">
                                    <label for="">Total Luas Bidang</label>
                                    <div class="row">
                                        <div class="col-11">
                                            <input type="number" id="luas_bidang" name="luas_bidang" class="form-control"
                                        value="{{ old('luas_bidang') }}" placeholder="Luas Total Bidang Tanah" min="0">
                                        </div>
                                        <div class="col-auto"><h3>/ m2</h3> </div>
                                    </div>
                                    {{-- {{ old('luas_bidang') }} --}}
                                </div>

                                <div class="col-12 row mt-5">
                                    <div class="col-6 my-1">
                                        <label for="">Koordinat Bidang Tanah</label><br>
                                        <span><small>Format File JSON/GEOJSON</small></span>
                                        <input type="file" id="koordinat_bidang" name="koordinat_bidang" class="form-control"
                                            style="border:none" value="{{ old('koordinat_bidang') }}">
                                    </div>

                                    <div class="col-6 my-1">
                                        <label for="">Peta Bidang Tanah</label><br>
                                        <span><small>Format File PDF</small></span>
                                        <input type="file" id="peta_bidang" name="peta_bidang" class="form-control"
                                            style="border:none" value="{{ old('peta_bidang') }}">
                                    </div>
                                </div>

                                <div class="col-12 my-1 d-none">
                                    <input type="number" class="d-none" id="status_pengerjaan" name="status_pengerjaan"
                                        value="{{ $guestLand->status_proses + 1 }}">
                                </div>

                                <div class="col-12 my-5 d-flex justify-content-end">
                                    <a href="{{ route('petugasPembuatanPeta') }}" class="btn btn-outline-primary mr-2">
                                        Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
    </x-app-layout>
