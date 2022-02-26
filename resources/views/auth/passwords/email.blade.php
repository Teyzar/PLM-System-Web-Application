@extends('layouts.app')

@section('head')

@endsection

@section('content')
    <div class="container col-md-8" style="margin-top: 10%">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success justify-content-center d-flex text-start border-0" role="alert"
                    style="margin-left: 30%; margin-right: 30% ">
                    <i class="fa-solid fa-inbox-out fs-5 pe-3 text-secondary"></i>{{ session('status') }}
                </div>
            @endif
        </div>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div id="modal-content" class="modal-content w-100 border border-secondary bg-light">
                <div class="modal-header border-0">
                    <h5 class="fs-6 d-flex text-secondary">Reset Password</h5>
                </div>
                <div class="modal-body border-0">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-3x text-danger"></i></h3>
                            <h4 class="text-center text-dark">Forgot password?</h4>
                            <div class="panel-body">
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group pt-3 justify-content-center">
                                        <div class="input-group">
                                            <i
                                                class="bi bi-envelope-check fs-2 pe-sm-2 text-dark opacity-75 align-items-center"></i>&nbsp;
                                            <input id="email" type="email"
                                                class="form-control float-start border @error('email') is-invalid @enderror"
                                                name="email" required autocomplete="email" autofocus
                                                placeholder="Enter E-mail Address here.." value="{{ old('email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <span id="errormsg"></span>
                                    </div>
                                    <div class="form-group pt-2">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                    </div>
                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer d-flex justify-content-center opacity-75">
            Copyright &copy; 2022 &mdash; Power Line Monitoring System
        </div>
    </div>
@endsection
