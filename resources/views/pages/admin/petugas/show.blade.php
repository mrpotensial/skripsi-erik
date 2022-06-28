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
        <script>
            $(document).ready(function() {});
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
            <div class="row">
                <div class="col-xl-6 col-md-12">
                    <h1 class="h3 mb-2 text-gray-800">Data Staff {{ $staff->name }}</h1>
                    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table
                        below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p>
                </div>
                <div class="col-xl-6 col-md-12 d-flex justify-content-end">
                    <div class="btn-group my-5">
                        <a class="btn btn-primary"
                            href="{{ route('operatorStaffEdit', ['id' => $staff->id]) }}">Tambah</a>
                        <a class="btn btn-primary" href="{{ route('operatorStaff') }}">Back</a>
                    </div>
                </div>
            </div>

            {{-- begin detail data guest --}}
            <div class="card shadow border border-secondary mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-secondary">Detail Staff</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Nama Petugas</td>
                                <td>{{ $staff->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $staff->email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- end detail data guest --}}

            {{-- begin detail data guest --}}
            <div class="card shadow border border-secondary mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-secondary">Daftar Pekerjaan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Pemilik</th>
                                    <th>Nomor Sertifikat</th>
                                    <th>NIB</th>
                                    <th>Alamat</th>
                                    <th>Nomor Telpon</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nama Pemilik</th>
                                    <th>Nomor Sertifikat</th>
                                    <th>NIB</th>
                                    <th>Alamat</th>
                                    <th>Nomor Telpon</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (count($guestLands) > 0)
                                    @foreach ($guestLands as $index => $guestLand)
                                        <tr class="m-auto p-auto">
                                            <td>{{ $guestLand->nama_pemilik }}</td>
                                            <td>{{ $guestLand->nomor_sertifikat }}</td>
                                            <td>{{ $guestLand->nib }}</td>
                                            <td>
                                                <div>
                                                    <h6>Desa <small><strong>{{ $guestLand->desa }}</strong></small>
                                                    </h6>
                                                    <h6>Kecamatan
                                                        <small><strong>{{ $guestLand->kecamatan }}</strong></small>
                                                    </h6>
                                                </div>
                                            </td>
                                            <td>{{ $guestLand->nomor_telpon }}</td>
                                            <td>
                                                @switch($guestLand->status_pengerjaan)
                                                    @case(1)
                                                        <small class="py-3">Pemilihan Petugas</small>
                                                    @break

                                                    @case(2)
                                                        <small class="py-3">Pengukuran Bidang</small>
                                                    @break

                                                    @case(3)
                                                        <small class="py-3">Pengerjaan Dokumen</small>
                                                    @break

                                                    @case(4)
                                                        <small class="py-3">Pekerjaan Selesai</small>
                                                    @break

                                                    @default
                                                        <small class="py-3">Pendaftaran</small>
                                                @endswitch
                                                @php
                                                    $progres = 20 * ($guestLand->status_pengerjaan + 1);
                                                @endphp
                                                <div class="progress mb-4">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: {{ $progres }}%"
                                                        aria-valuenow="{{ $progres }}" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <a class="btn btn-primary btn-sm my-1"
                                                        href="{{ route('operatorGuestLandShow', ['id' => $guestLand->id]) }}"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a class="btn btn-primary btn-sm my-1"
                                                        href="{{ route('operatorGuestLandEdit', ['id' => $guestLand->id]) }}"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a class="btn btn-danger btn-sm my-1"
                                                        href="{{ route('operatorGuestLandDestroy', ['id' => $guestLand->id]) }}"><i
                                                            class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            Data Kosong
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- end detail data guest --}}
            <hr>

            {{-- begin map --}}
            {{-- <div class="card shadow border border-secondary mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-secondary">Daftar Peta Lokasi Tanah</h5>
                </div>
                <div class="card-body">
                    <div id="map" name="map"></div>
                </div>
            </div> --}}
            {{-- end map --}}

        </div>
        <!-- /.container-fluid -->

    </div>
</x-app-layout>
