    <x-app-layout>
        <x-slot name="title">
            {{ __('Form Validasi Pengukuran Bidang Tanah') }}
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
                    <h1 class="h3 mb-0 text-gray-800">Formulir Upload Bukti Pengukuran Tanah Bidang </h1>
                    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
                </div>

                <!-- Content Row -->
                <form action="{{ route('petugasPengukuranBidangUpdate', ['id' => $guestLand->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="row">

                        <div class="col-12 my-1">
                            <label for="">Foto Bukti Pengukuran Bidang</label><br>
                            <span><small>Format File Image | jpg, png</small></span>
                            <input type="file" id="foto_bukti[]" name="foto_bukti[]" class="form-control"
                                style="border:none" value="{{ old('foto_bukti') }}" multiple>
                        </div>

                        <div class="col-12 my-1 d-none">
                            <input type="number" class="d-none" id="status_proses" name="status_proses"
                                value="{{ $guestLand->status_proses + 1 }}">
                        </div>


                        <div class="col-12 my-5 d-flex justify-content-end">
                            <a href="{{ route('petugasPengukuranBidang') }}" class="btn btn-outline-primary mr-2">
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
