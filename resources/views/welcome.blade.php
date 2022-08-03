<x-guest-layout>
    <x-slot name="title">
        {{ __('BPN SEKADAU') }}
    </x-slot>
    <x-slot name="headerLink">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
            integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
            crossorigin="" />
        <style>
            #map,
            #mapLayout {
                height: 400px;
                /* rounded: 1px; */
            }
        </style>
    </x-slot>
    <x-slot name="footerScript">
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
                integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
                crossorigin=""></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            // 0.0488547,109.3049425,8
            var map = L.map('map', {
                scrollWheelZoom: false
            }).setView([0.0086341, 110.9539717], 13);
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiYWJ1cml6YTIxIiwiYSI6ImNrdXplYzdrdDIwNDQzMnA2MnBwOWM4eDYifQ.p93OrqZyulIQoRNBeLNSqw'
            }).addTo(map);
            var marker = L.marker([0.0086341, 110.9539717]).addTo(map).bindPopup(
                "<div class='mx-auto text-center'<h1><strong>Kementrian Agraria dan Tata Ruang / <br>Badan Pertanahan Nasional</strong></h1><br><small>Kabupaten Sekadau</small><p>Gonis Tekam, Kec. Sekadau Hilir, Kabupaten Sekadau, Kalimantan Barat 79515</p></div>"
            ).openPopup();

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

            });
        </script>
    </x-slot>
    <div id="content">
        <!-- Topbar -->
        @include('layouts.navigation-guest')
        <!-- End of Topbar -->
        <div class="container-fluid my-5">

            <!-- Page Heading -->
            <div class="my-4 mx-auto ">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Selamat Datang di Aplikasi Monitoring Permohonan Pengukuran Bidang Tanah</h1>
                    </div>
                    {{-- <div class="w-100">
                        <form action="{{ route('SearchStore') }}" method="POST">
                            @method('POST')
                            @csrf
                            <input id="keynum" name="keynum" type="number"
                                class="form-control text-center" placeholder="Nomor Sertifikat atau NIB... ex 123"
                                min="0">

                        </form>
                    </div> --}}
                </div>
            </div>

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="card bg-dark text-white" style="max-height: 40rem">
                            <img src="{{ asset('/storage/app/1.jpeg') }}" class="card-img" alt="...">
                            {{-- <div class="card-img-overlay">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <p class="card-text">Last updated 3 mins ago</p>
                            </div> --}}
                        </div>
                        {{-- <img class="d-block w-100 rounded" src="" alt="First slide"> --}}
                    </div>
                    <div class="carousel-item">
                        <div class="card bg-dark text-white" style="max-height: 40rem">
                            <img src="{{ asset('/storage/app/2.jpeg') }}" class="card-img" alt="...">
                            {{-- <div class="card-img-overlay">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <p class="card-text">Last updated 3 mins ago</p>
                            </div> --}}
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card bg-dark text-white" style="max-height: 40rem">
                            <img src="{{ asset('/storage/app/3.jpeg') }}" class="card-img" alt="...">
                            {{-- <div class="card-img-overlay">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <p class="card-text">Last updated 3 mins ago</p>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>



            <!-- Content Row -->
            <div class="row mt-5">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-12 col-md-6 mb-4 text-center ">
                    <div class="card border-primary bg-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xx font-weight-bold text-white text-uppercase mb-1">
                                        Total Data Pemohon</div>
                                    <div class="h1 mb-0 font-weight-bold text-white">{{ $guestLand->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="map" name="map">
            </div>

            <!-- Content Row -->
            {{-- <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Data</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Pengunjung</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending Requests</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- Begin  Map --}}

            {{-- <div id="map" name="map"></div> --}}
            {{-- End Map --}}

        </div>
    </div>
</x-guest-layout>
