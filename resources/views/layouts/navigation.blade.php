@php
$auth = Auth::user()->level;
if ($auth == 0) {
    $homepage = 'admin';
} elseif ($auth == 1) {
    $homepage = 'koordinator';
} else {
    $homepage = 'petugas';
}
@endphp
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center my-4"
        href="{{ url($homepage . '/dashboard') }}">
        <div class="sidebar-brand-icon">
            <img style="width : 3rem" src="{{ asset('/storage/app/logo-bpn-sekadau.png') }}" alt="">
        </div>
        <div class="sidebar-brand-text ml-3 fs-1 mx-auto">
            <h5 class="font-weight-bold">BPN <small>Sekadau</small></h5>
        </div>
    </a>

    <!-- Divider -->
    {{-- <hr class="sidebar-divider my-0"> --}}

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url($homepage . '/dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
    </li>

    @if ($auth == 0)
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Data Wilayah
        </div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('adminKecamatan') }}">
                <i class="fas fa-fw fa-square"></i>
                <span>Kecamatan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('adminDesa') }}" >
                <i class="fas fa-fw fa-square"></i>
                <span>Desa</span>
            </a>
        </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Daftar Pengajuan Masyarakat
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('adminPemilihanPetugas') }}" >
            <i class="fas fa-fw fa-user-plus"></i>
            <span>Pemilihan Petugas</span>
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link" href="{{ route('adminGuestLand', ['proses']) }}" >
            <i class="fas fa-fw fa-box"></i>
            <span>Proses Pengerjaan</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('adminGuestLand', ['selesai']) }}" >
            <i class="fas fa-fw fa-box"></i>
            <span>Pekerjaan Selesai</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('adminPekerjaanKadaluarsa')}}">
            <i class="fas fa-fw fa-inbox"></i>
            <span>Permohonan Kadaluarsa</span>
        </a>
    </li>
    {{-- @elseif ($auth == 1)
        <a class="collapse-item" href="{{ route('petugasDaftarTugas') }}">Daftar Pekerjaan</a>
    @endif --}}

    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#guestland" aria-expanded="true"
            aria-controls="guestland">
            <i class="fas fa-fw fa-folder"></i>
            <span>Monitoring Pekerjaan</span>
        </a>
        <div id="guestland" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Proses :</h6>
                    <a class="collapse-item" href="{{ route('adminPemilihanPetugas') }}">Pemilihan Petugas</a>
                    <a class="collapse-item" href="{{ route('adminPengukuranBidang') }}">Pengukuran Bidang</a>
                    <a class="collapse-item" href="{{ route('adminPembuatanPeta') }}">Pembuatan Peta</a>
            </div>
        </div>
    </li> --}}


        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Petugas
        </div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('adminPetugas') }}" >
                <i class="fas fa-fw fa-user"></i>
                <span>Monitoring Petugas</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Data User
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#user" aria-expanded="true"
                aria-controls="user">
                <i class="fas fa-fw fa-user"></i>
                <span>Manajemen User</span>
            </a>
            <div id="user" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Daftar User :</h6>
                    <a class="collapse-item" href="{{ route('adminUser', ['select' => 'semua']) }}">Semua</a>
                    <a class="collapse-item" href="{{ route('adminUser', ['select' => 'admin']) }}">Admin</a>
                    <a class="collapse-item" href="{{ route('adminUser', ['select' => 'koordinator']) }}">Koordinator</a>
                    <a class="collapse-item" href="{{ route('adminUser', ['select' => 'petugas']) }}">Petugas</a>
                </div>
            </div>
        </li>
    @endif

    @if ($auth == 1)
        <div class="sidebar-heading">
            Daftar Validasi Pekerjaan
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('koordinatorDaftarPekerjaan') }}" >
                <i class="fas fa-fw fa-user"></i>
                <span>Daftar Pekerjaan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('koordinatorValidasiPekerjaan') }}" >
                <i class="fas fa-fw fa-user"></i>
                <span>Validasi Pekerjaan</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Petugas
        </div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('koordinatorPetugas') }}" >
                <i class="fas fa-fw fa-user"></i>
                <span>Monitoring Petugas</span>
            </a>
        </li>
    @endif

    @if ($auth == 2)
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Proses Pekerjaan
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('petugasDaftarTugas') }}">
                <i class="fas fa-fw fa-folder"></i>
                <span>Daftar Pekerjaan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('petugasPengukuranBidang') }}">
                <i class="fas fa-fw fa-folder"></i>
                <span>Bukti Pekerjaan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('petugasPembuatanPeta') }}">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pembuatan Peta</span>
            </a>
        </li>

        {{-- <div id="petugas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Proses Pengerjaan :</h6>
                    <a class="collapse-item" href="{{ route('petugasValidasiPekerjaan') }}">Validsasi Pekerjaan</a>
                    <a class="collapse-item" href="{{ route('petugasPengukuranBidang') }}">Pengukuran Bidang</a>
                    <a class="collapse-item" href="{{ route('petugasPembuatanPeta') }}">Pembuatan Peta</a>
                </div>
            </div> --}}
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
