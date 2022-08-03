<x-app-layout>
    <x-slot name="title">
        {{ __('Detail Pekerjaan '. $staff->name) }}
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
                            document.getElementById(elementId).innerHTML = "BATAS WAKTU SELESAI";
                        }
                    }, 1000);
                }
            });



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
                    <h1 class="h3 mb-2 text-gray-800">Detail {{ $staff->name }}</h1>
                    {{-- <p class="mb-4">Dsps://datatables.net">official DataTables documentation</a>.</p> --}}
                </div>
                {{-- <div class="col-xl-6 col-md-12 d-flex justify-content-end">
                    <div class="btn-group my-5">
                        <a class="btn btn-primary"
                            href="{{ route('adminPetugasEdit', ['id' => $staff->id]) }}">Tambah</a>
                        <a class="btn btn-primary" href="{{ route('adminPetugas') }}">Back</a>
                    </div>
                </div> --}}
            </div>

            {{-- begin detail data guest --}}
            <div class="card shadow mb-4">
                <div class="card-body">
                    <button class="btn btn-light w-100  text-left " type="button" data-bs-toggle="collapse" data-bs-target="#detail_petugas" aria-expanded="false" aria-controls="detail_petugas">
                        <i class="fas fa-square mr-3"></i>
                        <strong>Biodata {{$staff->name}}</strong>
                    </button>
                    <div class="collapse mt-3 show" id="detail_petugas">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>Nama Petugas</td>
                                    <td>{{ $staff->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $staff->email }}</td>
                                </tr>
                                <tr>
                                    <td>Total Pekerjaan</td>
                                    <td class="font-weight-bold">{{ $guestLands->count() }}</td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan Selesai</td>
                                    @php
                                        $count = 0;
                                        foreach ($guestLands as $guestLand) {
                                            if ($guestLand->status_proses == 5) {
                                                $count++;
                                            }
                                        }
                                    @endphp
                                    <td class="font-weight-bold">{{ $count }}</td>
                                </tr>
                                <tr>
                                    <td>Sedang Dikerjakan</td>
                                    @php
                                        $count = 0;
                                        foreach ($guestLands as $guestLand) {
                                            if ($guestLand->status_proses < 5) {
                                                $count++;
                                            }
                                        }
                                    @endphp
                                    <td class="font-weight-bold">{{ $count }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- end detail data guest --}}

            {{-- begin detail data guest --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-secondary">Daftar Pekerjaan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Waktu Pendaftaran</th>
                                    <th>Identitas Pemilik</th>
                                    <th>Berkas</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Waktu Pendaftaran</th>
                                    <th>Identitas Pemilik</th>
                                    <th>Berkas</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (count($guestLands) > 0)
                                    @foreach ($guestLands as $index => $guestLand)
                                        <tr class="m-auto p-auto align-middle">
                                            <td>
                                                <div>
                                                    <h5>
                                                        <strong>{{ $guestLand->created_at->format('d-m-Y')}}</strong>
                                                        {{-- <small>(<strong>{{ $guestLand->created_at->format('H:i:s') }}</strong>)</small> --}}
                                                    </h5>
                                                </div>
                                            </td>
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
                                                @php
                                                    $progres = ($guestLand->status_proses * 100) / 5;
                                                    if($progres == 0){
                                                        $progres = 5;
                                                    }
                                                @endphp
                                                <h5><small>Proses : </small> {{$guestLand->status_proses+1}}/6</h5>
                                                <h6>{{ $guestLand->judul_status_proses }}</h6>
                                                <div class="progress mb-2">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: {{ $progres }}%"
                                                        aria-valuenow="{{ $progres }}" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <h6 id="demo{{ $index }}"></h6>
                                            </td>
                                            <td class="d-flex justify-content-end">
                                                <div>
                                                    <a class="btn btn-icon btn-sm btn-primary btn-sm my-1"
                                                        href="{{ route('adminGuestLandShow', ['id' => $guestLand->id]) }}"><i
                                                            class="fas fa-eye mr-1"></i>Lihat</a>
                                                    <a class="btn btn-icon btn-sm btn-warning btn-sm my-1"
                                                        href="{{ route('adminGuestLandEdit', ['id' => $guestLand->id]) }}"><i
                                                            class="fas fa-edit mr-1"></i>Ubah</a>

                                                    <button type="button" class="btn btn-icon btn-danger btn-sm my-1" data-toggle="modal" data-target="#land{{$index}}">
                                                        <i class="fas fa-trash mr-1"></i>Hapus
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="land{{$index}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Data {{$guestLand->nama_pemilik}}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Apakah anda yakin ingin mengahapus data ini?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Batal</button>
                                                                    <a class="btn btn-icon btn-sm btn-danger btn-sm my-1"
                                                                        href="{{ route('adminGuestLandDestroy', ['id' => $guestLand->id]) }}"><i
                                                                            class="fas fa-trash mr-1"></i>Hapus</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
