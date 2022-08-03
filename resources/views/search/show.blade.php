<x-guest-layout>
    <x-slot name="title">
        {{ __($guestLand->nama_pemilik) }}
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
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
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

            // console.log(guestLand._layers);
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
            }];

            var overLayers = [{
                group: "Pengukuran Tanah",
                layers: [{
                    active: true,
                    name: "{{ $guestLand->nama_pemilik }}",
                    layer: guestLand
                }]
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
        @include('layouts.navigation-guest')
        <!-- End of Topbar -->
        <div class="container-fluid">

            {{-- begin progress --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-8">
                            <h5 class="m-0 font-weight-bold text-secondary">Progres Pengerjaan</h5>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                @if ($guestLand->status_proses == 5)
                                    <a class="btn btn-info btn-sm ml-1" href="{{ route('userDownload', [$guestLand->nib]) }}">
                                        <i class="fas fa-download mr-1"></i>
                                        Download
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    @php
                        $progres = ($guestLand->status_proses * 100) / 5;
                        if ($progres == 0) {
                            $progres = 5;
                        }

                        $step = $guestLand->status_proses +1;
                    @endphp
                    <h4 class="small font-weight-bold">{{ $guestLand->judul_status_proses }} <span
                        class="float-right">{{$step}}/6 ({{ round($progres) }}%)</span>
                    </h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progres }}%"
                            aria-valuenow="{{ $progres }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div>
                        <h3 id="countDown"></h3>
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


            @isset($guestLand->koordinat_bidang)
                {{-- begin map --}}
                <div class="card shadow mb-4">
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
    </div>
</x-guest-layout>
