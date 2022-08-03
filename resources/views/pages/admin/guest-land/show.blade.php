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
                $.getJSON('{{ asset('storage/' . $guestLand->koordinat_bidang) }}', function(j) {
                    l.addData(j);
                });
                return l;
            }());
            // console.log(guestLand);
            const statusPekerjaan = {{ Illuminate\Support\Js::from($guestLand->statusPekerjaans) }};
            const batas_waktu = {{ Illuminate\Support\Js::from($guestLand->batas_waktu_proses) }}
            const notice = "";

            // console.log(batas_waktu);
            $(document).ready(function() {
                // Set the date we're counting down to
                for (let index = 0; index < statusPekerjaan.length; index++) {
                    const element = statusPekerjaan[index];
                    // console.log();

                    var countDownDate = new Date(element.batas_waktu_pekerjaan).getTime();
                    countDown(countDownDate, 'countDown' + index);
                };

                var countDownDate = new Date(batas_waktu).getTime();
                countDown(countDownDate, 'countDown');

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
            <div class="row mb-5">
                <div class="col-xl-6 col-md-12">
                    <h1 class="h3 mb-2 text-gray-800">Data Tanah Kepemilikan {{ $guestLand->nama_pemilik }}</h1>
                    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table
                        below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> --}}
                </div>
                <div class="col-xl-6 col-md-12 d-flex justify-content-end">
                    <div>
                        {{-- Back Handler --}}
                        @if ($guestLand->status_proses < '4')
                            @if ($guestLand->status_proses == '0')
                                <a class="btn btn-icon btn-sm btn-primary" href="{{ route('adminPemilihanPetugas') }}"><i
                                class="fas fa-arrow-left mr-1"></i>Kembali</a>
                            @else
                                <a class="btn btn-icon btn-sm btn-primary" href="{{ route('adminGuestLand', ['proses']) }}"><i
                                class="fas fa-arrow-left mr-1"></i>Kembali</a>
                            @endif
                        @else
                            <a class="btn btn-icon btn-sm btn-primary" href="{{ route('adminGuestLand', ['selesai']) }}"><i
                                class="fas fa-arrow-left mr-1"></i>Kembali</a>
                        @endif


                        <a class="btn btn-icon btn-sm btn-warning ml-1"
                            href="{{ route('adminGuestLandEdit', ['id' => $guestLand->id]) }}"><i
                                class="fas fa-edit mr-1"></i>Ubah</a>
                        <a class="btn btn-icon btn-sm btn-danger ml-1"
                            href="{{ route('adminGuestLandDestroy', ['id' => $guestLand->id]) }}"><i
                                class="fas fa-trash mr-1"></i>Hapus</a>

                        @if ($guestLand->status_proses > 3)
                            <button type="button" class="btn btn-icon btn-info btn-sm my-1" data-toggle="modal" data-target="#showDocument">
                                <i class="fas fa-eye mr-1"></i>
                                Peta Bidang
                            </button>

                            <div class="modal fade" id="showDocument" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Peta Bidang </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <iframe src="{{asset('storage/'.$guestLand->peta_bidang)}}" style="width: 100%; height: 80rem" frameborder="0"></iframe>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a class="btn btn-icon btn-sm btn-info ml-1" href="{{ route('adminDownload', [$guestLand->nib]) }}"><i
                                    class="fas fa-download mr-1"></i>Download</a>


                        @endif
                        {{-- @if ($guestLand->status_pengerjaan == 4)
                            <a class="btn btn-primary ml-1"
                                href="{{ route('adminGuestLandPemeriksaanPekerjaan') }}"><i
                                    class="fas fa-check"></i></a>
                        @endif --}}
                    </div>
                </div>
            </div>
            {{-- begin progress --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3 ">
                    <h5 class="m-0 font-weight-bold text-secondary">Progress Pengerjaan</h5>
                </div>
                <div class="card-body">
                    @php
                        $progres = ($guestLand->status_proses * 100) / 5;
                        if($progres == 0){
                            $progres = 5;
                        }else {
                            $progres = round($progres);
                        }
                        $step = $guestLand->status_proses +1;
                    @endphp
                    <h4 class="small font-weight-bold">{{ $guestLand->judul_status_proses }} <span
                            class="float-right">{{$step}}/6 ({{ round($progres) }}%)</span>
                    </h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $progres }}%"
                            aria-valuenow="{{ $progres }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div>
                        <h5 id="countDown"></h5>
                    </div>
                </div>
            </div>
            {{-- end progres --}}

            {{-- begin detail data guest --}}
            <div class="card mb-4">
                <div class="card-body">
                    <button class="btn btn-light w-100  text-left " type="button" data-bs-toggle="collapse" data-bs-target="#detail_pemohon" aria-expanded="false" aria-controls="detail_pemohon">
                        <i class="fas fa-square mr-3"></i>
                        <strong>Detail Data</strong>
                    </button>
                    <div class="collapse mt-3 show" id="detail_pemohon">
                        <table class="table table-hover table-sm">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-3 font-weight-bold">
                                                Nama 
                                            </div>
                                            <div class="col-9">
                                                {{ $guestLand->nama_pemilik }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-3 font-weight-bold">
                                                Nomor Sertifikat
                                            </div>
                                            <div class="col-9">
                                                {{ $guestLand->nomor_sertifikat }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-3 font-weight-bold">
                                                NIB
                                            </div>
                                            <div class="col-9">
                                                {{ $guestLand->nib }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-3 font-weight-bold">
                                                Desa
                                            </div>
                                            <div class="col-9">
                                                {{ $guestLand->village->nama_desa }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-3 font-weight-bold">
                                                Kecamatan
                                            </div>
                                            <div class="col-9">
                                                {{ $guestLand->village->district->nama_kecamatan }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-3 font-weight-bold">
                                                Nomor Telepon
                                            </div>
                                            <div class="col-9">
                                                {{ $guestLand->nomor_telpon }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-3 font-weight-bold">
                                                Luas Tanah
                                            </div>
                                            <div class="col-9">
                                                {{ $guestLand->luas_tanah ?? "0" }} <small>m2</small>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- end detail data guest --}}

            @if ($guestLand->user_id != null)
                {{-- begin detail data guest --}}
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <button class="btn btn-light w-100 text-left " type="button" data-bs-toggle="collapse" data-bs-target="#detail_petugas" aria-expanded="false" aria-controls="detail_petugas">
                            <i class="fas fa-square mr-3"></i>
                            <strong>Detail Petugas</strong>
                        </button>
                        <div class="collapse mt-3" id="detail_petugas">
                            <table class="table table-hover table-sm">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-3 font-weight-bold">
                                                    Nama Petugas
                                                </div>
                                                <div class="col-9">
                                                    {{ $guestLand->user->name }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-3 font-weight-bold">
                                                    Email
                                                </div>
                                                <div class="col-9">
                                                    {{ $guestLand->user->email }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- end detail data guest --}}
            @endif

            {{-- begin detail data guest --}}
            <div class="card shadow mb-4">
                <div class="card-body">
                    <button class="btn btn-light w-100  text-left " type="button" data-bs-toggle="collapse" data-bs-target="#status_pengerjaan" aria-expanded="false" aria-controls="status_pengerjaan">
                        <i class="fas fa-square mr-3"></i>
                        <strong>Status Pengerjaan</strong>
                    </button>
                    <div class="collapse mt-3" id="status_pengerjaan">
                        <table class="table table-sm table-hover">
                            <thead class="table-active">
                                <tr>
                                    <th>Status Pekerjaan</th>
                                    <th>Waktu Pembuatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guestLand->statusPekerjaans as $index => $status)
                                    <tr>
                                        <td>
                                            <h6 class="font-weight-bold">{{ $status->judul_pekerjaan }}
                                            </h6>
                                        </td>
                                        <td>{{ $status->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- end detail data guest --}}

            {{-- begin map --}}
            @isset($guestLand->koordinat_bidang)
            <div class="card shadow mb-4">
                <div class="card-body">
                    <button class="btn btn-light w-100  text-left " type="button" data-bs-toggle="collapse" data-bs-target="#peta" aria-expanded="false" aria-controls="peta">
                        <i class="fas fa-square mr-3"></i>
                        <strong>Peta Lokasi Tanah</strong>
                    </button>
                    <div class="collapse mt-3" id="peta">
                        <div id="map" name="map"></div>
                    </div>
                </div>
            </div>
            @endisset
            {{-- end map --}}

            @if ($guestLand->buktiPekerjaans->count() > 0)
                <div class="card shadow mb-4">
                    <div class="card-body py-3">
                        <button class="btn btn-light w-100  text-left " type="button" data-bs-toggle="collapse" data-bs-target="#buktipekerjaan" aria-expanded="false" aria-controls="buktipekerjaan">
                            <i class="fas fa-square mr-3"></i>
                            <strong>Bukti Pekerjaan</strong>
                        </button>
                        <div class="collapse mt-3" id="buktipekerjaan">
                            <div class="row p-5 d-grid gap-3">
                                @foreach ($guestLand->buktiPekerjaans as $bukti_pekerjaan)
                                <div class="col-12 col-md-6 col-xl-3 card" style="width: 18rem;">
                                    <img src="{{ asset('storage/' . $bukti_pekerjaan->path) }}" class="card-img-top"
                                    alt="...">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <!-- /.container-fluid -->

    </div>
</x-app-layout>
