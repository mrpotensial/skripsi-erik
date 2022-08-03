<x-app-layout>
    <x-slot name="title">
        {{ __('Admin | Pembuatan Peta') }}
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
            const guestLands = {{ Illuminate\Support\Js::from($guestLands) }};
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
            <h1 class="h3 mb-2 text-gray-800">Pembuatan Koordinat dan Peta Bidang Tanah </h1>
            {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                For more information about DataTables, please visit the <a target="_blank"
                    href="https://datatables.net">official DataTables documentation</a>.</p> --}}

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
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
                                        <tr class="m-auto p-auto">
                                            <td>
                                                <div>
                                                    <h6>Nama Pemilik :
                                                        <strong>{{ $guestLand->nama_pemilik }}</strong>
                                                        <small>(<strong>{{ $guestLand->nomor_telpon }}</strong>)</small>
                                                    </h6>
                                                    <div class="d-flex">
                                                        <h6 class=" mr-3">Desa
                                                            <small><strong>{{ $guestLand->Village->nama_desa }}</strong></small>
                                                        </h6>
                                                        <h6>Kecamatan
                                                            <small><strong>{{ $guestLand->Village->district->nama_kecamatan }}</strong></small>
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
                                                {{-- {{ $status = count($guestLand->statusPekerjaan) }} --}}
                                                <h5>{{ $guestLand->judul_status_proses }}</h5>
                                                <h6 id="demo{{ $index }}"></h6>
                                            </td>
                                            <td>
                                                @php
                                                    $progres = ($guestLand->status_proses * 100) / 6;
                                                @endphp
                                                <div class="progress mb-4">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: {{ $progres }}%"
                                                        aria-valuenow="{{ $progres }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('adminPembuatanPetaShow', [$guestLand->id]) }}"
                                                        class="btn btn-primary btn-sm my-1"><i class="fas fa-eye"></i>
                                                    </a>

                                                    {{-- <a class="btn btn-primary btn-sm my-1"
                                                        href="{{ route('adminPengukuranBidangUpdate', ['id' => $guestLand->id]) }}"><i
                                                            class="fas fa-edit"></i></a> --}}
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
