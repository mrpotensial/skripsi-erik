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

        @include('layouts.navbar')

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data Tanah Pemohon</h1>
            {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                For more information about DataTables, please visit the <a target="_blank"
                    href="https://datatables.net">official DataTables documentation</a>.</p> --}}

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}
                    {{-- <div class="d-flex justify-content-end">
                        <a href="{{ route('operatorGuestLandCreate') }}" class="btn btn-primary"><i
                                class="fas fa-plus"></i></a>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Total</th>
                                    <th>Pengukuran</th>
                                    <th>Peta</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nama</th>
                                    <th>Total</th>
                                    <th>Pengukuran</th>
                                    <th>Peta</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (count($staffs) > 0)
                                    @foreach ($staffs as $index => $staff)
                                        @php
                                            $total_pekerjaan = 0;
                                            $status0 = 0;
                                            $status1 = 0;
                                            foreach ($guestLands as $guestLand) {
                                                $staff->id == $guestLand->user_id ? $total_pekerjaan++ : null;
                                                if ($staff->id == $guestLand->user_id) {
                                                    $guestLand->status_proses == 1 ? $status0++ : null;
                                                    $guestLand->status_proses == 2 ? $status1++ : null;
                                                }
                                            }
                                        @endphp
                                        <tr class="m-auto p-auto">
                                            <td>{{ $staff->name }}</td>
                                            <td>{{ $total_pekerjaan }}</td>
                                            <td>{{ $status0 }}</td>
                                            <td>{{ $status1 }}</td>
                                            <td class="d-flex justify-content-end">
                                                <div>
                                                            <a class="btn btn-primary btn-sm btn-icon"
                                                        href="{{ route('koordinatorPetugasShow', ['id' => $staff->id]) }}"><i
                                                            class="fas fa-eye mr-1"></i>Lihat Detail Pekerjaan</a>
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

        </div>
        <!-- /.container-fluid -->

    </div>
</x-app-layout>
