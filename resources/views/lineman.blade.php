@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/lineman.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('body')
    <div class="container mt-4">
        <div class="card-header border-black border border-1 fw-bolder fs-5 count bg-light text-dark"
            style="font-family: 'Montserrat', sans-serif;">
            {{ __('Accounts ') . '(' . count($users) . ')' }}
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
                @if (count($users) > 0)
                    <table class="table table-hover table-md text-start"
                        style="font-family: 'Montserrat', sans-serif; background-color:#ff7300;">
                        <thead class="table-warning opacity-75 text-dark">
                            <tr style="font-family: 'Times New Roman', Times, serif"
                                class="border-dark border fs-5 text-black">
                                <th width="25%">Name</th>
                                <th width="25%">E-mail</th>
                                <th width="20%">Designation</th>
                                <th width="20%">Registration Date</th>
                                <th width="3%">&nbsp;</th>
                                <th width="3%">&nbsp;</th>
                                <th width="3%">&nbsp;</th>

                            </tr>
                        </thead>

                        <tbody class="border border-1 searchbody" id="tb" style="">
                            @foreach ($users as $user)
                                <tr class="trbody bg-light border border-dark">
                                    <td class="fs-6 text-black border-top fw-bolder">
                                        {{ ucfirst($user->name) }}</a>
                                    </td>
                                    <td class="text-black fs-6 border-top fw-bolder">{{ $user->email }}
                                    </td>
                                    <td class="text-black fs-6 text-capitalize border-top fw-bolder">
                                        {{ $user->barangay }}</td>
                                    <td class="text-black fs-6 text-capitalize border-top fw-bolder">
                                        {{ \Carbon\Carbon::parse($user->created_at)->toDayDateTimeString() }}</td>
                                    <td class="">
                                        <a class="resetbtn" onclick="EditAccount({{ $user->id }})">
                                            <i class="fas fa-sync-alt text-success fs-6" data-toggle="tooltip"
                                                title="Reset password"></i>
                                        </a>
                                    </td>
                                    <td class="">
                                        <a class="editbtn" onclick="LoadAccountDetails({{ $user->id }})"
                                            data-bs-toggle="modal" data-bs-target="#modalForm2">
                                            <i class="fas fa-user-edit text-primary fs-6" data-toggle="tooltip"
                                                title="Edit"></i>
                                        </a>
                                    </td>
                                    <td class="">
                                        <a id="delbtn" class="deletebtn" data-bs-toggle="modal"
                                            data-bs-target="#modalDelete" onclick="Destroy({{ $user->id }})">
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
                        {!! $users->links() !!}
                    </div>
                @endif

                @if (count($users) <= 0)
                    <div class="card border-1 border-secondary align-items-center pt-5 ">
                        <span class="justify-content-center d-flex fw-bold pb-5 pt-2 text-secondary opacity-75 addicon fs-3"
                            style="font-family: 'Montserrat', sans-serif;">No Registered Accounts</span>
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
                        url: "{{ URL::to('search/lineman') }}",
                        data: {
                            'search': $value
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('.searchbody').html(data.success);
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

        function LoadAccountDetails(id) {
            event.preventDefault();
            var params = '?id=' + id;
            var route = 'lineman/' + id;
            $.ajax({
                type: 'get',
                url: "{{ URL::to('/lineman/edit/') }}",
                dataType: 'json',
                data: params,
                success: function(data) {
                    const name = $('input#updatename');
                    const barangay = $('input#updatebarangay');
                    const email = $('input#updateemail');

                    name.val(data.name);
                    barangay.val(data.barangay);
                    email.val(data.email);
                    $('#form-id').attr('action', `lineman/${data.id}`);
                }
            });
        }
    </script>

    @include('modals.modal')

@endsection
