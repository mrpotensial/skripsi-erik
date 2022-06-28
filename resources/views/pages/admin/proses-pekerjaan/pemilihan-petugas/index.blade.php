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
            const guestLands = {{ Illuminate\Support\Js::from($guestLands) }};
            $(document).ready(function() {
                // Set the date we're counting down to
                for (let index = 0; index < guestLands.length; index++) {
                    const element = guestLands[index];

                    var countDownDate = new Date(element.batas_waktu_proses).getTime();

                    countDown(countDownDate, 'demo' + index);
                };

                // Update the count down every 1 second
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
                            document.getElementById(elementId).innerHTML = "EXPIRED";
                        }
                    }, 1000);
                }
            });
        </script>
    </x-slot>
    <div id="content">

        @include('layouts.navbar')

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Data Pemohon Belum Memiliki Petugas</h1>
            {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                For more information about DataTables, please visit the <a target="_blank"
                    href="https://datatables.net">official DataTables documentation</a>.</p> --}}

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('adminGuestLandCreate') }}" class="btn btn-primary"><i
                                class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Identitas Pemilik</th>
                                    <th>Berkas</th>
                                    <th>Status</th>
                                    <th>Prorgres</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Identitas Pemilik</th>
                                    <th>Berkas</th>
                                    <th>Status</th>
                                    <th>Prorgres</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (count($guestLands) > 0)
                                    @foreach ($guestLands as $index => $guestLand)
                                        @if ($guestLand->user_id == null)
                                            <tr class="m-auto p-auto align-middle">
                                                <td>
                                                    <div>
                                                        <h6>Nama Pemilik :
                                                            <strong>{{ $guestLand->nama_pemilik }}</strong>
                                                            <small>(<strong>{{ $guestLand->nomor_telpon }}</strong>)</small>
                                                        </h6>
                                                        <div class="d-flex">
                                                            <h6 class=" mr-3">Desa
                                                                <small><strong>{{ $guestLand->village->nama_desa }}</strong></small>
                                                            </h6>
                                                            <h6>Kecamatan
                                                                <small><strong>{{ $guestLand->village->district->nama_kecamatan }}</strong></small>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <h6>Nomor Sertifikat :
                                                            <small><strong>{{ $guestLand->nomor_sertifikat }}</strong></small>
                                                        </h6>
                                                        <h6>NIB :
                                                            <small><strong>{{ $guestLand->nib }}</strong></small>
                                                        </h6>
                                                        <h6>Nomor Hak :
                                                            <small><strong>{{ $guestLand->nomor_hak }}</strong></small>
                                                        </h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h5>{{ $guestLand->judul_status_proses }}</h5>
                                                    <h5 id="demo{{ $index }}"></h5>
                                                </td>
                                                <td>
                                                    @php
                                                        $progres = ($guestLand->status_proses * 7) / 100;
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
                                                            href="{{ route('adminGuestLandShow', ['id' => $guestLand->id]) }}"><i
                                                                class="fas fa-eye"></i></a>
                                                        <a class="btn btn-primary btn-sm my-1"
                                                            href="{{ route('adminPemilihanPetugasEdit', ['id' => $guestLand->id]) }}"><i
                                                                class="fas fa-edit"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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
