<x-app-layout>
    <x-slot name="title">
        {{ __('BPN SEKADAU') }}
    </x-slot>
    <x-slot name="headerLink">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
            integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
            crossorigin="" />
        <link rel="stylesheet"
            href="{{ asset('assets/vendor/leaflet-panel-layers-master') }}/src/leaflet-panel-layers.css" />
        <style>
            #map,
            #mapLayout {
                height: 600px;
                /* rounded: 1px; */
            }
        </style>
    </x-slot>
    <x-slot name="footerScript">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
                integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
                crossorigin=""></script>
        <script src="{{ asset('assets/vendor/leaflet-panel-layers-master') }}/src/leaflet-panel-layers.js"></script>
        <script src="{{ asset('assets/vendor/leaflet-panel-layers-master/examples') }}/data/bar.js"></script>
        <script src="{{ asset('assets/vendor/leaflet-panel-layers-master/examples') }}/data/drinking_water.js"></script>
        <script>
            const guestLand = (function() {
                var l = L.geoJson();
                $.getJSON("{{ asset('storage/' . $kecamatan->koordinat_bidang_kecamatan) }}", function(j) {
                    l.addData(j);
                });
                return l;
            }());
            var map = L.map('map', {
                    zoom: 15,
                    center: L.latLng([0.01195500848542409, 110.9013491117639]),
                }),
                osmLayer = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

            map.addLayer(osmLayer);

            var baseLayers = [{
                name: "Open Street Map",
                layer: osmLayer
            }];

            var overLayers = [{
                group: "Pengukuran Tanah",
                layers: [{
                    active: true,
                    name: "{{ $kecamatan->nama_kecamatan }}",
                    layer: guestLand
                }, ]
            }];

            var panelLayers = new L.Control.PanelLayers(baseLayers, overLayers, {
                //compact: true,
                //collapsed: true,
                collapsibleGroups: true
            });

            map.addControl(panelLayers);
        </script>
    </x-slot>
    <div id="content">

        <!-- Topbar -->
        @include('layouts.navbar')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-xl-6 col-md-12">
                    <h1 class="h3 mb-2 text-gray-800">Data Tanah Kepemilikan {{ $kecamatan->nama_kecamatan }}</h1>
                    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table
                        below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p>
                </div>
                <div class="col-xl-6 col-md-12 d-flex justify-content-end">
                    <div class="my-5">
                        <a class="btn btn-primary" href="{{ route('adminKecamatan') }}"><i
                                class="fas fa-arrow-left"></i></a>
                        <a class="btn btn-primary ml-1" href="{{ route('adminKecamatanCreate') }}"><i
                                class="fas fa-plus"></i></a>
                        <a class="btn btn-primary ml-1"
                            href="{{ route('adminKecamatanEdit', ['id' => $kecamatan->id]) }}"><i
                                class="fas fa-edit"></i></a>
                        <a class="btn btn-danger ml-1"
                            href="{{ route('adminKecamatanDestroy', ['id' => $kecamatan->id]) }}"><i
                                class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
            {{-- begin progress --}}
            {{-- <div class="card shadow border border-secondary mb-4">
                <div class="card-header py-3 ">
                    <h5 class="m-0 font-weight-bold text-secondary">Progress Pengerjaan</h5>
                </div>
                <div class="card-body">
                    @php
                        $progres = 20 * $guestLand->status_pengerjaan;
                    @endphp
                    @switch($guestLand->status_pengerjaan)
                        @case(1)
                            <h4 class="small font-weight-bold">Pemilihan Petugas <span
                                    class="float-right">{{ $progres }}%</span>
                            </h4>
                        @break

                        @case(2)
                            <h4 class="small font-weight-bold">Pengukuran Bidang <span
                                    class="float-right">{{ $progres }}%</span>
                            </h4>
                        @break

                        @case(3)
                            <h4 class="small font-weight-bold">Pengerjaan Dokumen <span
                                    class="float-right">{{ $progres }}%</span>
                            </h4>
                        @break

                        @case(4)
                            <h4 class="small font-weight-bold">Validasi Pekerjaan <span
                                    class="float-right">{{ $progres }}%</span>
                            </h4>
                        @break

                        @case(5)
                            <h4 class="small font-weight-bold">Pekerjaan Selesai <span class="float-right">Complete!</span>
                            </h4>
                        @break

                        @default
                            <h4 class="small font-weight-bold">Pendaftaran <span
                                    class="float-right">{{ $progres }}%</span>
                            </h4>
                    @endswitch
                    @if ($progres == 100)
                        <div class="progress mb-4">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progres }}%"
                                aria-valuenow="{{ $progres }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @else
                        <div class="progress mb-4">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $progres }}%"
                                aria-valuenow="{{ $progres }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @endif
                </div>
            </div> --}}
            {{-- end progres --}}

            {{-- begin map --}}
            <div class="card shadow border border-secondary mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-secondary">Peta Lokasi Tanah</h5>
                </div>
                <div class="card-body">
                    <div id="map" name="map"></div>
                </div>
            </div>
            {{-- end map --}}

        </div>
        <!-- /.container-fluid -->

    </div>
</x-app-layout>
