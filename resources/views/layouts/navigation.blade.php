@php
$auth = Auth::user()->level;
if ($auth == 0) {
    $homepage = 'admin';
} else {
    $homepage = 'petugas';
}
@endphp
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ url($homepage . '/dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-user"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            @if (Auth::user()->level == 0)
                {{ Auth::user()->name }} <small>Admin</small>
            @else
                {{ Auth::user()->name }} <small>Petugas</small>
            @endif
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url($homepage . '/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
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
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#kec" aria-expanded="true"
                aria-controls="kec">
                <i class="fas fa-fw fa-user"></i>
                <span>Kecamatan</span>
            </a>
            <div id="kec" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Kecamatan :</h6>
                    <a class="collapse-item" href="{{ route('adminKecamatan') }}">Daftar Kecamatan</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#desa" aria-expanded="true"
                aria-controls="desa">
                <i class="fas fa-fw fa-user"></i>
                <span>Desa</span>
            </a>
            <div id="desa" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Daftar Tanah :</h6>
                    <a class="collapse-item" href="{{ route('adminDesa') }}">Daftar Desa</a>
                </div>
            </div>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Masyarakat
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pengajuan Pengukuran</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Daftar Tanah :</h6>
                @if ($auth == 0)
                    <a class="collapse-item" href="{{ route('adminGuestLand') }}">Daftar Pengajuan</a>
                @elseif ($auth == 1)
                    <a class="collapse-item" href="{{ route('petugasDaftarTugas') }}">Daftar Pekerjaan</a>
                @endif
            </div>
        </div>
    </li>


    @if ($auth == 0)
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#petugas" aria-expanded="true"
                aria-controls="petugas">
                <i class="fas fa-fw fa-user"></i>
                <span>Proses Pengajuan</span>
            </a>
            <div id="petugas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Proses Pengerjaan :</h6>
                    <a class="collapse-item" href="{{ route('adminPemilihanPetugas') }}">Pemilihan Petugas</a>
                    <a class="collapse-item" href="{{ route('adminPengukuranBidang') }}">Pengukuran Bidang</a>
                    <a class="collapse-item" href="{{ route('adminPembuatanPeta') }}">Pembuatan Peta</a>
                    <a class="collapse-item" href="{{ route('adminValidasiPekerjaan') }}">Validasi Pekerjaan</a>
                </div>
            </div>
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
                <span>User</span>
            </a>
            <div id="user" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Daftar User :</h6>
                    <a class="collapse-item" href="{{ route('adminUser', ['select' => 'all']) }}">Semua</a>
                    <a class="collapse-item" href="{{ route('adminUser', ['select' => 'admin']) }}">Admin</a>
                    <a class="collapse-item" href="{{ route('adminUser', ['select' => 'petugas']) }}">Petugas</a>
                </div>
            </div>
        </li>
    @endif

    @if ($auth == 1)
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Proses Pekerjaan
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#petugas" aria-expanded="true"
                aria-controls="petugas">
                <i class="fas fa-fw fa-user"></i>
                <span>Proses</span>
            </a>
            <div id="petugas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Proses Pengerjaan :</h6>
                    <a class="collapse-item" href="{{ route('petugasValidasiPekerjaan') }}">Validsasi Pekerjaan</a>
                    <a class="collapse-item" href="{{ route('petugasPengukuranBidang') }}">Pengukuran Bidang</a>
                    <a class="collapse-item" href="{{ route('petugasPembuatanPeta') }}">Pembuatan Peta</a>
                </div>
            </div>
        </li>
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
