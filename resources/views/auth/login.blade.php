<x-auth-layout>
    <x-slot name="title">

    </x-slot>
    <x-slot name="headerLink">

    </x-slot>
    <x-slot name="footerScript">

    </x-slot>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center mt-5">

            <div class="col-xl-6 col-lg-7 col-md-8">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center border-bottom-primary">
                                        <div>
                                            <h1 class="text-gray-900">Masuk</h1>
                                            <small>Login Aplikasi BPN SEKADAU</small>
                                        </div>
                                    </div>
                                    <hr>
                                    @if ($errors->any())
                                        <div>
                                            <div class="text-red-600">
                                                {{ __('Whoops! Something went wrong.') }}
                                            </div>

                                            <ul class="mt-3 list-inside text-red-600">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email"
                                                aria-describedby="emailHelp" placeholder="Email"
                                                value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <select name="level" id="level" class="form-control">
                                                <option value="1">
                                                    Petugas</option>
                                                <option value="0">
                                                    Admin</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="remember_me">
                                                <label class="custom-control-label" for="remember_me">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="form-control mt-3 btn btn-primary">
                                            Login
                                        </button>
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
