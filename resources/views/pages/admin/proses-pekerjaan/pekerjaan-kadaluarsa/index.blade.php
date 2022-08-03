<x-app-layout>
    <x-slot name="title">
        {{ __('Daftar Data Pemohon') }}
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
                for (let index = 0; index < {{ Illuminate\Support\Js::from($guestLands) }}.length; index++) {
                    const element = {{ Illuminate\Support\Js::from($guestLands) }}[index];
                    var countDownDate = new Date(element.created_at).getTime();

                    countDown(countDownDate, 'demo' + index);
                };

                // Update the count down every 1 second
                function countDown(countDownDate, elementId) {
                    var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();

                        // Find the distance between now and the count down date
                        var distance = now - countDownDate;

                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Output the result in an element with id="demo"
                        document.getElementById(elementId).innerHTML = days + "d " + hours + "h " +
                            minutes + "m " + seconds + "s ";

                        // If the count down is over, write some text
                        // if (distance < 0) {
                        //     clearInterval(x);
                        //     document.getElementById(elementId).innerHTML = "EXPIRED";
                        // }
                    }, 1000);
                }
            });
        </script>
    </x-slot>
    <div id="content">

        @include('layouts.navbar')

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <div>
                <!-- Page Heading -->

            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}
                    <div class="row">
                        <div class="col-6">
                            <h1 class="h3 mb-2 text-gray-800">Data Permohonan Kadaluarsa</h1>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-end">
                                {{-- <label for="">Hapus</label> --}}
                                <a href="{{ route('adminPekerjaanKadaluarsaDestroy') }}" class="btn btn-icon btn-sm btn-danger"><i
                                    class="fas fa-trash mr-1"></i>Hapus Semua</a>

                            </div>
                            <small class="d-flex justify-content-end mt-2">Hapus Semua data pemohon lebih dari 10 hari pendaftaran</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <h5>Daftar Data Pemohon lebih dari 7 hari pendaftaran</h5>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Waktu Pendaftaran</th>
                                    <th>Identitas Pemilik</th>
                                    <th>Berkas</th>
                                    <th>Waktu Keterlambatan</th>
                                    {{-- <th>Prorgres</th> --}}
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Waktu Pendaftaran</th>
                                    <th>Identitas Pemilik</th>
                                    <th>Berkas</th>
                                    <th>Waktu Keterlambatan</th>
                                    {{-- <th>Prorgres</th> --}}
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (count($guestLands) > 0)
                                    @foreach ($guestLands as $index => $guestLand)
                                        <tr class="m-auto p-auto align-item-center">
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
                                                {{-- <h5>{{ $guestLand->judul_status_proses }}</h5> --}}
                                                <h5 id="demo{{ $index }}"></h5>
                                            </td>
                                            <td class="d-flex justify-content-end">
                                                <div>
                                                    <a class="btn btn-icon btn-primary btn-sm my-1"
                                                        href="{{ route('adminGuestLandShow', ['id' => $guestLand->id]) }}"><i
                                                            class="fas fa-eye mr-1"></i>Lihat</a>
                                                    <a class="btn btn-icon btn-secondary btn-sm my-1"
                                                        href="{{ route('adminPekerjaanKadaluarsaUpdate', ['id' => $guestLand->id]) }}"><i
                                                            class="far fa-arrow-alt-circle-up mr-1"></i>Kembalikan</a>
                                                    {{-- <a class="btn btn-danger btn-sm my-1"
                                                        href="{{ route('adminGuestLandDestroy', ['id' => $guestLand->id]) }}"><i
                                                            class="fas fa-trash"></i></a> --}}
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
                                                    {{-- @if ($guestLand->user_id == null)
                                                        <a class="btn btn-danger btn-sm my-1"
                                                            href="{{ route('adminPengukuranBidang') }}"><i
                                                                class="fas fa-plus"></i></a>
                                                    @endif --}}
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
