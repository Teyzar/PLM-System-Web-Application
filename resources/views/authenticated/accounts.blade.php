@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/home.js') }}" defer></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection


@section('body')
    <div class="container mt-5 ">
        <div class="card align-items-center w-auto flex-row justify-content-between p-2 fs-5 px-3">
            Accounts<a href="" class="btn bg-danger text-light a:hover bg-dark" data-bs-toggle="modal"
                data-bs-target="#modalForm">
                Register Accounts
            </a>
        </div>
    </div>
    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Account Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Name" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Email" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Baranggay</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Barrangay" />
                        </div>
                        <div class="modal-footer d-block d-flex align-items-center justify-content-center border-1">
                            <button type="submit" class="btn btn-warning w-75">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
