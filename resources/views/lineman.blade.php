@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/lineman.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('body')
    <div class="container mt-4">
        <div class="card-header border-black border border-1 fs-5 count bg-light text-dark">
            {{ 'Accounts (' . count($linemen) . ')' }}
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

            <a href="" class="addicon text-dark" data-bs-toggle="modal" data-bs-target="#modalRegisterForm" data-toggle="tooltip"
                title="Register">
                <i class="fad fa-user-plus fs-3 addicon"></i>
            </a>

        </div>
    </div>

    <div class="container m-auto">
        <div class="row">
            <div class="border-dark table-responsive-sm">
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
                                        <a id="resetbtn" class="resetbtn" onclick="resetPassword({{ $lineman->id }})"
                                            data-bs-toggle="modal" data-bs-target="#modalReset">
                                            <i class="fas fa-sync-alt text-success fs-6" data-toggle="tooltip"
                                                title="Reset password"></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <a class="editbtn" onclick="editAccount({{ $lineman->id }})"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit">
                                            <i class="fas fa-user-edit text-primary fs-6" data-toggle="tooltip"
                                                title="Edit"></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <a id="delbtn" class="deletebtn" data-bs-toggle="modal"
                                            data-bs-target="#modalDelete" onclick="deleteAccount({{ $lineman->id }})">
                                            <i class="fas fa-trash fs-6 text-danger" data-toggle="tooltip"
                                                title="Delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- pagination --}}
                    <div class="d-flex justify-content-center fs-10">
                        {{ $linemen->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($errors->has('email'))
        <script>
            $(document).ready(() => {
                $('#modalRegisterForm').modal('show');
            });
        </script>
    @endif

    <script>
        $(document).ready(() => {
            $('[data-toggle="tooltip"]').tooltip();
            try {
                $('#search').on('keyup', () => {
                    $value = $(this).val();
                    $.ajax({
                        type: 'get',
                        url: 'lineman-search',
                        data: {
                            'searchTerm': $value
                        },
                        dataType: 'json',
                        success: (data) => {
                            $('.searchbody').html(data.result);
                            $('[data-toggle="tooltip"]').tooltip();
                            $('.count').html(`Accounts (${data.count})`);
                        },
                        error: (err) => console.error(err)
                    });
                })
            } catch (error) {
                console.error(error);
            }
        });

        function deleteAccount(id) {
            $('#delete-id').attr('action', `lineman/${id}`);
        }

        function resetPassword(id) {
            $.ajax({
                type: 'get',
                url: `lineman/${id}`,
                dataType: 'json',
                success: (data) => {
                    $('input#resetEmail').val(data.email);
                    $("#reset-id").submit((event) => {
                        event.preventDefault();
                        $.ajax({
                            type: 'post',
                            url: `lineman/${data.id}/reset`,
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: (data) => {
                                if (data === "0") {
                                    $('#modal-content').css({
                                        'border-color': 'red',
                                        'border-width': '2px',
                                    });

                                    $('#text-msg').css({
                                        'color': 'red'
                                    });

                                    setTimeout(() => {
                                        $('#modal-content').css({
                                            'border-color': '',
                                            'border-width': 'thin'
                                        });

                                        $('#text-msg').css({
                                            'color': '#262626'
                                        });
                                    }, 3000)
                                } else {
                                    $('#modalReset').fadeOut(500);

                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            },
                            error: (err) => console.error(err)
                        })
                    });
                },
                error: (err) => console.error(err)
            });
        }

        function editAccount(id) {
            $.ajax({
                type: 'get',
                url: `lineman/${id}`,
                dataType: 'json',
                success: (data) => {
                    $('input#updatename').val(data.name);
                    $('input#updatebarangay').val(data.barangay);
                    $('input#updateemail').val(data.email);
                    $('#modalEditForm').attr('action', `lineman/${data.id}`);
                },
                error: (err) => console.error(err)
            });
        }
    </script>

    @include('modals.lineman')

@endsection
