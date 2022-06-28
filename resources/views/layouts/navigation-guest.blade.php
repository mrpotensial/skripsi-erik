<nav class="navbar navbar-expand navbar-light bg-primary topbar mb-5 static-top shadow">


    <a class="navbar-brand text-white fs-1" href="{{ url('') }}">
        <img class="navbar-item mr-1" style="width : 2rem" src="{{ asset('/storage/app/logo-bpn-sekadau.png') }}"
            alt="">
        <strong>BPN SEKADAU</strong>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Topbar Search -->
    <div class="navbar-nav ml-auto">
        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
            action="{{ route('SearchStore') }}" method="POST">
            @method('POST')
            @csrf
            <div class="input-group">
                <input id="keynum" name="keynum" type="number" class="form-control bg-light border-0 small"
                    placeholder="Lihat data  tanah..." aria-label="Search" aria-describedby="basic-addon2"
                    min="0">
                <div class="input-group-append">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-user"></i>
                    <span class="ml-3 fw-bold">
                        @if (Auth::user()->level == 0)
                            {{ Auth::user()->name }} <small>Admin</small>
                        @else
                            {{ Auth::user()->name }} <small>Petugas</small>
                        @endif
                    </span>
                </a>
            </li>
        @endauth
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-user"></i>
                    <span class="ml-3 fw-bold">Login</span>
                </a>
            </li>
        @endguest
    </ul>
</nav>
