@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/home.js') }}" defer></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('body')
    <div class="container mt-4">
        <div class="card-header">{{ __('Accounts') }}

            <span class="fs-6 text-danger float-end"><div class = "count">{{count($users)}}</div></span>

        </div>
        <div class="card align-items-center flex-row justify-content-center fs-5 px-3 bg-light">
            <i class="bi bi-search p-1 bg-light"></i>
            <div class="container p-2">
                <div class="row height d-flex justify-content-start flex-row navbar navbar-expand-sm">
                    <div class="col-md-8">
                        <div class="search d-flex"><input type="text" class="form-control" placeholder="Search Accounts..."
                                name="search" id="search">
                        </div>
                    </div>
                </div>
            </div>
            <a href="" class="btn text-light bg-danger py-2 px-5 w-auto" data-bs-toggle="modal" data-bs-target="#modalForm">
                <span class="text-light align-items-center w-0">Register</span>
            </a>
        </div>
    </div>
    <div class="container m-auto">
        <div class="table-responsive table-bordered border-dark">
            @if (count($users) > 0)
                <table class="table bg-white table-bordered table-hover">
                    <thead>
                        <tr style="font-family: sans-serif">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Baranggay</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
                        </tr>
                    </thead>
                    <tbody class="searchbody" id="tb">
                        <tr class ="no-data">
                            <td colspan="4">No Record Found</td>
                        </tr>
                        @foreach ($users as $user)
                            <tr style="font-family: sans-serif">
                                <td><a href="/accounts/{{ $user->id }}/edit"
                                        class="fs-6 text-decoration-none text-capitalize text-muted">{{ ucfirst($user->name) }}</a>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td class="text-capitalize">{{ $user->baranggay }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>

                                <td class="justify-content-center d-flex p-1">
                                    <a href="/accounts/{{ $user->id }}/edit"
                                        class="btn btn-outline-primary fs-6 py-1 px-4">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <div class = "d">

                    </div>
                    <script>
                        $(document).ready(function() {
                            $('.no-data').hide();
                            $('#search').on('keyup', function() {
                                $value = $(this).val();

                                $.ajax({
                                    type: 'get',
                                    url: '{{ URL::to('search') }}',
                                    data: {
                                        'search': $value
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        if ($value.length > 0) {
                                            $('.searchbody').html(data.success);
                                            $('.count').html(data.count);

                                        } else {
                                            $('.searchbody').html(`@foreach ($users as $user)
                                                <tr style="font-family: sans-serif">
                                                    <td><a href="/accounts/{{ $user->id }}/edit"
                                                            class="fs-6 text-decoration-none text-capitalize text-muted">{{ ucfirst($user->name) }}</a>
                                                    </td>
                                                    <td>{{ $user->email }}</td>
                                                    <td class="text-capitalize">{{ $user->baranggay }}</td>
                                                    <td>{{ $user->created_at }}</td>
                                                    <td>{{ $user->updated_at }}</td>

                                                    <td class="justify-content-center d-flex p-1">
                                                        <a href="/accounts/{{ $user->id }}/edit" class="btn btn-outline-primary fs-6 py-1 px-4">Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach`);
                                            $('.count').html('<div class = "count">{{count($users)}}</div>');
                                        }
                                    }
                                });
                            })
                        })
                    </script>
                </table>
                <div class="d-flex justify-content-center fs-7">
                    {!! $users->links() !!}
                </div>
            @endif
            @if (count($users) <= 0)
                <table class="table table-bordered" border="3">
                    <tbody>
                        <div class="center justify-content-center d-flex mt-5">
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
