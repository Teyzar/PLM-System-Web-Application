@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/lineman.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('body')
    <div class="container mt-4">
        <div class="card-header border-black border border-1 fs-5 count bg-light text-dark">
            {{ __('Accounts ') . '(' . count($linemen) . ')' }}
        </div>

        <div class="card align-items-center flex-row justify-content-center fs-5 px-3 bg-light border border-black border-1">
            <i class="bi bi-search p-1 text-dark"></i>
            <div class="container p-2">
                <div class="row height d-flex justify-content-start flex-row navbar navbar-expand-sm">
                    <div class="col-md-8">
                        <div class="search d-flex"><input type="text" class="form-control border-warning border-1"
                                placeholder="Search accounts..." name="search" id="search">
                        </div>
                    </div>
                </div>
            </div>

            <a href="" class="addicon text-dark" data-bs-toggle="modal" data-bs-target="#modalForm" data-toggle="tooltip"
                title="Register">
                <i class="fad fa-user-plus fs-3 addicon"></i>
            </a>

        </div>
    </div>

    <div class="container m-auto">
        <div class="row">
            <div class="border-dark table-responsive">
                @if (count($linemen) <= 0)
                    <div class="card border-1 border-secondary align-items-center pt-5 ">
                        <span
                            class="justify-content-center d-flex fw-bold pb-5 pt-2 text-secondary opacity-75 addicon fs-3">
                            No Registered Accounts
                        </span>
                    </div>
                @else
                    <table class="table table-hover table-md text-start">
                        <thead class="table-success">
                            <tr class="border-dark border fs-5 text-dark">
                                <th width="25%">Name</th>
                                <th width="25%">E-mail</th>
                                <th width="20%">Designation</th>
                                <th width="20%">Registration Date</th>
                                <th width="3%">&nbsp;</th>
                                <th width="3%">&nbsp;</th>
                                <th width="3%">&nbsp;</th>
                            </tr>
                        </thead>

                        <tbody class="border border-1 searchbody bg-light" id="tb">
                            @foreach ($linemen as $lineman)
                                <tr class="trbody bg-light border border-dark">
                                    <td class="fs-6 text-black border-top text-capitalize">
                                        {{ $lineman->name }}</a>
                                    </td>

                                    <td class="text-black fs-6 border-top">
                                        {{ $lineman->email }}
                                    </td>

                                    <td class="text-black fs-6 text-capitalize border-top">
                                        {{ $lineman->barangay }}
                                    </td>

                                    <td class="text-black fs-6 text-capitalize border-top">
                                        {{ \Carbon\Carbon::parse($lineman->created_at)->toDayDateTimeString() }}
                                    </td>

                                    <td class="">
                                        <a id="resetbtn" class="resetbtn" onclick="Reset({{ $lineman->id }})"
                                            data-bs-toggle="modal" data-bs-target="#modalReset">
                                            <i class="fas fa-sync-alt text-success fs-6" data-toggle="tooltip"
                                                title="Reset password"></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <a class="editbtn" onclick="LoadAccountDetails({{ $lineman->id }})"
                                            data-bs-toggle="modal" data-bs-target="#modalForm2">
                                            <i class="fas fa-user-edit text-primary fs-6" data-toggle="tooltip"
                                                title="Edit"></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <a id="delbtn" class="deletebtn" data-bs-toggle="modal"
                                            data-bs-target="#modalDelete" onclick="Destroy({{ $lineman->id }})">
                                            <i class="fas fa-trash fs-6 text-danger" data-toggle="tooltip"
                                                title="Delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- pagination --}}
                    <div class="d-flex justify-content-center fs-7">
                        {!! $linemen->links() !!}
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

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            try {
                $('#search').on('keyup', function() {
                    $value = $(this).val();
                    $.ajax({
                        type: 'get',
                        url: `{{ URL::to('lineman-search') }}`,
                        data: {
                            'searchTerm': $value
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('.searchbody').html(data.result);
                            $('[data-toggle="tooltip"]').tooltip();
                            $('.count').html(`Accounts (${data.count})`);
                        }
                    });
                })
            } catch (error) {
                console.error(error);
            }
        });

        function Destroy(id) {
            $('#delete-id').attr('action', `lineman/${id}`);
        }

        function Reset(id) {
            $.ajax({
                type: 'get',
                url: `{{ URL::to('lineman/${id}') }}`,
                dataType: 'json',
                success: function(data) {
                    const email = $('input#email');
                    email.val(data.email);
                    $('#reset-id').attr('action', `{{ URL::to('lineman/reset/${data.id}') }}`);
                    $("#reset-id").submit(function(event) {
                        event.preventDefault();
                        var form = $(this);
                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: form.serialize(),
                            dataType: 'json',
                            success: function(data) {

                                if (data === "0") {
                                    $('#errormsg').html(`<div id="errormsg" class="error text-danger p-2">Please check to confirm the Email address.
                                    </div>`);
                                } else {
                                    location.reload();
                                }
                            },
                            error: function(data) {
                                console.log('An error occurred.');
                                console.log(data);
                            },
                        })
                    });
                },
            });
        }

        function LoadAccountDetails(id) {
            $.ajax({
                type: 'get',
                url: `{{ URL::to('lineman/${id}') }}`,
                dataType: 'json',
                success: function(data) {
                    const name = $('input#updatename');
                    const barangay = $('input#updatebarangay');
                    const email = $('input#updateemail');

                    name.val(data.name);
                    barangay.val(data.barangay);
                    email.val(data.email);
                    $('#form-id').attr('action', `{{ URL::to('lineman/${data.id}') }}`);
                }
            });
        }
    </script>

    @include('modals.modal')

@endsection
