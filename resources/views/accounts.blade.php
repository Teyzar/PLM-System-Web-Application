@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/home.js') }}" defer></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
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
            <a href="" class="btn text-light a:hover bg-danger" style="width:22%" data-bs-toggle="modal"
                data-bs-target="#modalForm">
                Register Accounts
            </a>
        </div>
    </div>
    <div class="container m-auto">
        <div class="table-responsive">
            <table class="table table-bordered bg-white" border="3">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->password }}</td>
                            <td class="justify-content-end d-flex">
                                <button type="button" class="btn btn-outline-primary">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center fs-7">
                {!! $users->links() !!}
            </div>

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
