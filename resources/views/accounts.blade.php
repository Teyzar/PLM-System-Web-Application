@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/home.js') }}" defer></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('body')
    <div class="container mt-4">
        <div class="card-header">{{ __('Accounts') }}</div>
        <div class="card align-items-center flex-row justify-content-center fs-5 px-3 bg-light">
            <i class="bi bi-search p-1 bg-light"></i>
            <div class="container p-2">
                <div class="row height d-flex justify-content-start flex-row navbar navbar-expand-sm">
                    <div class="col-md-8">
                        <div class="search d-flex"><input type="text" class="form-control"
                                placeholder="Search Accounts..."> <button class="btn btn-secondary">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/accounts" class="btn text-light a:hover bg-danger" data-bs-toggle="modal"
                data-bs-target="#modalForm">
                Register Account
            </a>
        </div>
    </div>
    <div class="container m-auto">
        <div class="table-responsive">
            @if (count($users) > 0)
                <table class="table bg-white" border="3">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Baranggay</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->baranggay }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>

                                <td class="justify-content-end d-flex">
                                    <a href="/accounts/{{ $user->id }}/edit" class="btn btn-outline-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center fs-7">
                    {!! $users->links() !!}
                </div>
            @endif
            @if (count($users) <= 0)
                <table class="table table-bordered" border="3">
                    <tbody>

                        <div class = "center justify-content-center d-flex mt-5">
                            No account Registered
                        </div>

                    </tbody>
                </table>
            @endif



        </div>
    </div>
    @if (count($errors) > 0)
        <script>
            $(document).ready(function() {
                $('#modalForm').modal('show');
            });
        </script>
    @endif

    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Account Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('accounts.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Name" required autocomplete="name" autofocus
                                value="{{ old('name') }}">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="Email" required autocomplete="email"
                                value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <div class="error text-danger">{{ $errors->first('email') }}</div>

                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Password" required=""
                                value="{{ old('password') }}">
                            @if ($errors->has('password'))
                                <div class="error text-danger">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmpass" name="confirmpass"
                                placeholder="Confirm Password" required="" value="{{ old('confirmpass') }}">
                            @if ($errors->has('confirmpass'))
                                <div class="error text-danger">{{ $errors->first('confirmpass') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Baranggay</label>
                            <input type="text" class="form-control" id="baranggay" name="baranggay"
                                placeholder="Barrangay" required="" value="{{ old('baranggay') }}">
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
