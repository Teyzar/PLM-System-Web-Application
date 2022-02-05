@extends('layouts.app')

@section('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
@endsection

@section('content')
    <div class="container py-4" style="margin-top: 9%">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-info bg-light">
                    <div class="card-header border-gray bg-dark fs-6">
                        <span class="fs-6 text-light">{{ __('Login Account') }}</span>
                        <p class="fs-6 text-center fw-bolder text-light" style="font-family: 'Montserrat', sans-serif;">
                            Welcome to
                            <span class="text-danger fs-4">Power Line
                                Monitoring</span>
                        </p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3 justify-content-center">
                                {{-- <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label> --}}

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email">
                                    @if ($errors->has('email'))
                                        <div class="error text-danger">{{ $errors->first('email') }}</div>

                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-center">
                                {{-- <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> --}}

                                <div class="col-md-8">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" value="{{ old('password') }}"
                                        placeholder="Password">
                                    @if ($errors->has('password'))
                                        <div class="error text-danger">{{ $errors->first('password') }}</div>

                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check ">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary bg-success px-4">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-info" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
