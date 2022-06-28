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
                $.getJSON('{{ asset($guestLand->koordinat_bidang) }}', function(j) {
                    l.addData(j);
                });
                return l;
            }());

            const statusPekerjaan = {{ Illuminate\Support\Js::from($guestLand->statusPekerjaan) }};
            const notice = "";
            // console.log(statusPekerjaan);
            $(document).ready(function() {
                // Set the date we're counting down to
                for (let index = 0; index < statusPekerjaan.length; index++) {
                    const element = statusPekerjaan[index];
                    // console.log();

                    var countDownDate = new Date(element.batas_waktu_pekerjaan).getTime();
                    countDown(countDownDate, 'countDown' + index);
                };

                function countDown(countDownDate, elementId) {
                    var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();

                        // Find the distance between now and the count down date
                        var distance = countDownDate - now;

                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Output the result in an element with id="demo"
                        document.getElementById(elementId).innerHTML = days + "d " + hours + "h " +
                            minutes + "m " + seconds + "s ";

                        // If the count down is over, write some text
                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById(elementId).innerHTML = "HABIS";
                        }
                    }, 1000);
                };
            });

            var map = L.map('map', {
                    zoom: 15,
                    center: L.latLng([0.01195500848542409, 110.9013491117639]),
                    // attributionControl: false,
                    // maxBounds: L.latLngBounds([
                    //     [42.41281, 12.28821],
                    //     [42.5589, 12.63805]
                    // ]).pad(0.5)
                }),
                osmLayer = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

            map.addLayer(osmLayer);

            var baseLayers = [{
                    name: "Open Street Map",
                    layer: osmLayer
                },
                {
                    name: "Hiking",
                    layer: L.tileLayer("https://toolserver.org/tiles/hikebike/{z}/{x}/{y}.png")
                },
                {
                    name: "Aerial",
                    layer: L.tileLayer('https://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.{ext}', {
                        type: 'sat',
                        ext: 'jpg',
                        attribution: 'Tiles Courtesy of <a href="https://www.mapquest.com/">MapQuest</a> &mdash; Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency',
                        subdomains: '1234'
                    })
                },
                {
                    group: "Road Layers",
                    collapsed: true,
                    layers: [{
                            name: "Open Cycle Map",
                            layer: L.tileLayer('https://{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png')
                        },
                        {
                            name: "Transports",
                            layer: L.tileLayer('https://{s}.tile2.opencyclemap.org/transport/{z}/{x}/{y}.png')
                        }
                    ]
                }
            ];

            var overLayers = [{
                group: "Pengukuran Tanah",
                layers: [{
                    active: true,
                    name: "{{ $guestLand->nama_pemilik }}",
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
                    <h1 class="h3 mb-2 text-gray-800">Data Tanah Kepemilikan {{ $guestLand->nama_pemilik }}</h1>
                    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table
                        below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p>
                </div>
                <div class="col-xl-6 col-md-12 d-flex justify-content-end">
                    <div class="my-5">
                        <a class="btn btn-primary" href="{{ route('adminGuestLand') }}"><i
                                class="fas fa-arrow-left"></i></a>
                        <a class="btn btn-primary ml-1" href="{{ route('adminGuestLandCreate') }}"><i
                                class="fas fa-plus"></i></a>
                        <a class="btn btn-primary ml-1"
                            href="{{ route('adminGuestLandEdit', ['id' => $guestLand->id]) }}"><i
                                class="fas fa-edit"></i></a>
                        <a class="btn btn-danger ml-1"
                            href="{{ route('adminGuestLandDestroy', ['id' => $guestLand->id]) }}"><i
                                class="fas fa-trash"></i></a>
                        {{-- @if ($guestLand->status_pengerjaan == 4)
                            <a class="btn btn-primary ml-1"
                                href="{{ route('adminGuestLandPemeriksaanPekerjaan') }}"><i
                                    class="fas fa-check"></i></a>
                        @endif --}}
                    </div>
                </div>
            </div>
            {{-- begin progress --}}
            <div class="card shadow border border-secondary mb-4">
                <div class="card-header py-3 ">
                    <h5 class="m-0 font-weight-bold text-secondary">Progress Pengerjaan</h5>
                </div>
                <div class="card-body">
                    @php
                        $progres = 20 * (count($guestLand->statusPekerjaan) - 1);
                    @endphp
                    @switch(count($guestLand->statusPekerjaan))
                        @case(1)
                            @php
                                $status_name = 'Pendaftaran';
                            @endphp
                            <h4 class="small font-weight-bold">Pendaftaran <span
                                    class="float-right">{{ $progres }}%</span>
                            </h4>
                        @break

                        @case(2)
                            @php
                                $status_name = 'Pemilihan Petugas';
                            @endphp
                            <h4 class="small font-weight-bold">Pemilihan Petugas <span
                                    class="float-right">{{ $progres }}%</span>
                            </h4>
                        @break

                        @case(3)
                            @php
                                $status_name = 'Pengukuran Bidang';
                            @endphp
                            <h4 class="small font-weight-bold">Pengukuran Bidang <span
                                    class="float-right">{{ $progres }}%</span>
                            </h4>
                        @break

                        @case(4)
                            @php
                                $status_name = 'Pengerjaan Dokumen';
                            @endphp
                            <h4 class="small font-weight-bold">Pengerjaan Dokumen <span
                                    class="float-right">{{ $progres }}%</span>
                            </h4>
                        @break

                        @case(5)
                            @php
                                $status_name = 'Validasi Pekerjaan';
                            @endphp
                            <h4 class="small font-weight-bold">Validasi Pekerjaan <span
                                    class="float-right">{{ $progres }}%</span>
                            </h4>
                        @break

                        @case(6)
                            @php
                                $status_name = 'Pekerjaan Selesai';
                            @endphp
                            <h4 class="small font-weight-bold">Pekerjaan Selesai <span class="float-right">Complete!</span>
                            </h4>
                        @break

                        @default
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
            </div>
            {{-- end progres --}}

            {{-- begin detail data guest --}}
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
            {{-- end detail data guest --}}
            @if ($guestLand->user_id != null)
                {{-- begin detail data guest --}}
                <div class="card shadow border border-secondary mb-4">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-secondary">Detail Petugas</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Nama Petugas</td>
                                    <td>{{ $guestLand->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $guestLand->user->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- end detail data guest --}}
            @endif

            {{-- begin detail data guest --}}
            <div class="card shadow border border-secondary mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-secondary">Detail Progres Pengerjaan</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Status Pekerjaan</th>
                                <th>Pembuatan</th>
                                <th>Batas Akhir</th>
                                <th>Hitung Mundur</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Status Pekerjaan</th>
                                <th>Pembuatan</th>
                                <th>Batas Akhir</th>
                                <th>Hitung Mundur</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($guestLand->statusPekerjaan as $index => $status)
                                <tr>
                                    <td>
                                        @switch(($status->status_pekerjaan+1))
                                            @case(1)
                                                <h4 class="small font-weight-bold">Pendaftaran
                                                </h4>
                                            @break

                                            @case(2)
                                                <h4 class="small font-weight-bold">Pemilihan Petugas
                                                </h4>
                                            @break

                                            @case(3)
                                                <h4 class="small font-weight-bold">Pengukuran Bidang
                                                </h4>
                                            @break

                                            @case(4)
                                                <h4 class="small font-weight-bold">Pengerjaan Dokumen
                                                </h4>
                                            @break

                                            @case(5)
                                                <h4 class="small font-weight-bold">Validasi Pekerjaan
                                                </h4>
                                            @break

                                            @case(6)
                                                <h4 class="small font-weight-bold">Pekerjaan Selesai
                                                </h4>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>{{ $status->created_at }}</td>
                                    <td>{{ $status->batas_waktu_pekerjaan }}</td>
                                    <td>
                                        <h6 id="countDown{{ $index }}"></h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- end detail data guest --}}
            <hr>

            {{-- begin map --}}
            @isset($guestLand->koordinat_bidang)
                <div class="card shadow border border-secondary mb-4">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-secondary">Peta Lokasi Tanah</h5>
                    </div>
                    <div class="card-body">
                        <div id="map" name="map"></div>
                    </div>
                </div>
            @endisset
            {{-- end map --}}

        </div>
        <!-- /.container-fluid -->

    </div>
</x-app-layout>
