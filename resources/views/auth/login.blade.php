<x-auth-layout>
    <x-slot name="title">

    </x-slot>
    <x-slot name="headerLink">

    </x-slot>
    <x-slot name="footerScript">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $(document).ready(function() {
                if ({{ Illuminate\Support\Js::from($errors->any()) }}) {

                    $({{ Illuminate\Support\Js::from($errors->all()) }}).each(function(i, val) {
                        swal({
                            title: "Perhatian!",
                            text: val,
                            icon: "warning",
                        });
                    })

                }

            });
        </script>
    </x-slot>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center" style="margin-top: 20%">

            <div class="col-xl-6 col-lg-7 col-md-8">

                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center border-bottom-primary mb-3">
                                        <div class="mb-3">
                                            <img style="width : 7rem" src="{{ asset('/storage/app/logo-bpn-sekadau.png') }}" alt="">
                                        </div>
                                        <div>
                                            <small class="font-weight-bold">Login Aplikasi BPN SEKADAU</small>
                                        </div>
                                    </div>

                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" placeholder="Email" required
                                                autocomplete="email" autofocus>
                                            @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                name="password" placeholder="Password" required autocomplete="current-password">
                                            @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <select name="level" id="level" class="form-control">
                                                <option value="2">
                                                    Petugas</option>
                                                <option value="1">
                                                    Koordinator</option>
                                                <option value="0">
                                                    Admin</option>
                                            </select>
                                            @error('level')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="remember_me">
                                                <label class="custom-control-label" for="remember_me">Ingat Saya</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="form-control mt-3 btn btn-primary">
                                            Masuk
                                        </button>
                                        <a href="{{route('welcome')}}" class="form-control mt-3 btn btn-outline-primary">
                                            Kembali
                                        </a>
                                    </form>
                                    <hr>
                                    {{-- <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-auth-layout>
