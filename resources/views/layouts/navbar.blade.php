<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <div class="nav-link">
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
                <small>{{Str::title($homepage)}} <strong> {{ Auth::user()->name }}</strong></small>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="nav-link" href="route('logout')" onclick="event.preventDefault();
                                            this.closest('form').submit();">
                    Keluar
                </a>
            </form>
        </li>

    </ul>

</nav>
