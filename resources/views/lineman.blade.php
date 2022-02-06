@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/home.js') }}" defer></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('body')
    <div class="container mt-4">
        <div class="card-header border-dark border-1">{{ __('Accounts') }}

            <span class="fs-6 text-danger float-end">
                <div class="count fw-bolder text-dark" style="font-family: 'Montserrat', sans-serif;">{{ count($users) }}
                </div>
            </span>

        </div>
        <div class="card align-items-center flex-row justify-content-center fs-5 px-3 bg-light">
            <i class="bi bi-search p-1 text-dark"></i>
            <div class="container p-2">
                <div class="row height d-flex justify-content-start flex-row navbar navbar-expand-sm">
                    <div class="col-md-8">
                        <div class="search d-flex"><input type="text" class="form-control border-warning border-1"
                                placeholder="Search Accounts..." name="search" id="search">
                        </div>
                    </div>
                </div>
            </div>
            @if (count($users) > 0)
                <a href="" class="addicon text-dark" data-bs-toggle="modal" data-bs-target="#modalForm"
                    data-toggle="tooltip" title="Register">
                    <i class="fad fa-user-plus fs-3 addicon"></i>
                </a>
            @endif
        </div>
    </div>
    <div class="container m-auto">
        <div class="row">
            <div class="border-dark table-responsive">
                @if (count($users) > 0)
                    <table class="table table-hover table-white table-md text-start"
                        style="font-family: 'Montserrat', sans-serif; border-width: 1px;">
                        <thead class="table-warning opacity-75 text-dark">
                            <tr style="font-family: sans-serif; border-width: 1px;"
                                class="border-warning border-warning border-top fw-bolder">
                                <th width="25%">Name</th>
                                <th width="25%">Email</th>
                                <th width="20%">Barangay</th>
                                <th width="17.5%">Date</th>
                                <th width="3%">&nbsp;</th>
                                <th width="3%">&nbsp;</th>
                                <th width="3%">&nbsp;</th>

                            </tr>
                        </thead>
                        <tbody class="border-warning border-top searchbody" id="tb" style="border-width: 1px">
                            @foreach ($users as $user)
                                <tr class="trbody border-warning border-top">
                                    <td class="fs-6 text-muted border-warning border-top fw-bolder">
                                        {{ ucfirst($user->name) }}</a>
                                    </td>
                                    <td class="text-black fs-6 border-warning border-top fw-bolder">{{ $user->email }}
                                    </td>
                                    <td class="text-black fs-6 text-capitalize border-warning border-top fw-bolder">
                                        {{ $user->barangay }}</td>
                                    <td class="text-black fs-6 text-capitalize border-warning border-top fw-bolder">
                                        {{ \Carbon\Carbon::parse($user->created_at)->toDayDateTimeString() }}</td>
                                    <td class="">
                                        <a class="resetbtn" onclick="EditAccount({{ $user->id }})">
                                            <i class="fas fa-sync-alt text-success fs-6" data-toggle="tooltip"
                                                title="password reset"></i>
                                        </a>
                                    </td>
                                    <td class="">
                                        <a class="editbtn" onclick="LoadAccountDetails({{ $user->id }})"
                                            data-bs-toggle="modal" data-bs-target="#modalForm2">
                                            <i class="fas fa-user-edit text-primary fs-6" data-toggle="tooltip"
                                                title="edit"></i>
                                        </a>
                                    </td>
                                    <td class="">
                                        <a id="delbtn" class="deletebtn" data-bs-toggle="modal"
                                            data-bs-target="#modalDelete" onclick="Destroy({{ $user->id }})">
                                            <i class="fas fa-trash fs-6 text-danger" data-toggle="tooltip"
                                                title="delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
            </div>
            </table>
            <div class="d-flex justify-content-center fs-7">
                {!! $users->links() !!}
            </div>
            @endif
            @if (count($users) <= 0)
                <div class="card border-1 border-secondary align-items-center pt-5 ">
                    <i style="cursor: pointer" class="fad fa-user-plus fs-1 addicon" data-bs-toggle="modal"
                        data-bs-target="#modalForm"></i>
                    <span class="justify-content-center d-flex fw-bold pb-5 pt-2 text-danger opacity-75 addicon"
                        style="font-family: 'Montserrat', sans-serif;">Register Account</span>
                </div>
            @endif
        </div>

    </div>
    </div>
    @if ($errors->has('email'))
        <script>
            $(document).ready(function() {
                $('#modalForm').modal('show');
            });
        </script>
    @endif
    <style>
        .modal-open .container-fluid,
        .modal-open .container {
            -webkit-filter: blur(5px) grayscale(90%);
        }

    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            try {
                $('#search').on('keyup', function() {
                    $value = $(this).val();
                    $.ajax({
                        type: 'get',
                        url: "{{ URL::to('search') }}",
                        data: {
                            'search': $value
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('.searchbody').html(data.success);
                            $('[data-toggle="tooltip"]').tooltip();
                            $('.count').html(data.count);
                        }
                    });
                })
            } catch (error) {
                console.log(error);
            }

        });

        function Destroy(id) {
            $('#delete-id').attr('action', `lineman/${id}`);
        }

        function LoadAccountDetails(id) {
            event.preventDefault();
            var params = '?id=' + id;
            var route = 'lineman/' + id;
            $.ajax({
                type: 'get',
                url: "{{ route('lineman-edit') }}",
                dataType: 'json',
                data: params,
                success: function(data) {
                    $('input#updatename').val(data.name);
                    $('input#updatebarangay').val(data.barangay);
                    $('input#updateemail').val(data.email);
                    $('#form-id').attr('action', `lineman/${data.id}`);
                }
            });
        }
    </script>
    @include('modals.modal')
@endsection
