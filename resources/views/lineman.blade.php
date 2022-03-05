@extends('layouts.app')

@section('title', '- Accounts')

@section('head')
    <link href="{{ mix('css/lineman.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
@endsection

@section('body')
    <div class="container mt-4">
        <div class="card bg-light border-0 p-2 inner-menu shadow align-items-center flex-row px-3">
            <i class="bi bi-search p-1 text-dark fs-5"></i>
            <div class="container p-1">
                <div class="row justify-content-start flex-row">
                    <div class="col-md-8">
                        <div class="search d-flex"><input type="text" class="form-control" placeholder="Search accounts..."
                                name="search" id="search">
                        </div>
                    </div>
                </div>
            </div>

            <a href=""
                class="addicon text-dark bs-tooltip-top tooltip-arrow btn btn-warning d-flex align-items-center px-3 py-1 addicon"
                data-bs-toggle="modal" data-bs-target="#modalRegisterForm" data-toggle="tooltip" title="Register">
                <i class="fa-solid fa-plus pe-2"></i>Register
            </a>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row">
            <div class="table-responsive-md">
                @if (count($linemen) <= 0)
                    <table id="table" class="table border table-md text-start">
                        <thead class="">
                            <tr class="client--nav-tabs text-secondary">
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Designation</th>
                                <th>Registration&nbsp;Date</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                    </table>
                @else
                    <table id="table" class="table border table-md text-start">
                        <thead class="table table-md inner-menu shadow">
                            <tr class="client--nav-tabs text-dark">
                                <th width="20%">Name</th>
                                <th width="20%">E-mail</th>
                                <th width="20%">Designation</th>
                                <th width="15%">Registration&nbsp;Date</th>
                                <th width="2.5%">&nbsp;</th>
                                <th width="2.5%">&nbsp;</th>
                                <th width="2.5%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody class="searchbody bg-light" id="tb">
                            @foreach ($linemen as $lineman)
                                <tr class="trbody bg-light tdhover">
                                    <td class="text-black text-capitalize">
                                        {{ $lineman->name }}</a>
                                    </td>

                                    <td class="text-black">
                                        {{ $lineman->email }}
                                    </td>

                                    <td class="text-black text-capitalize">
                                        {{ $lineman->barangay }}
                                    </td>

                                    <td class="text-black text-capitalize">
                                        {{ \Carbon\Carbon::parse($lineman->created_at)->toDayDateTimeString() }}
                                    </td>

                                    <td class="">
                                        <a id="resetbtn" class="resetbtn"
                                            onclick="resetPassword({{ $lineman->id }})" data-bs-toggle="modal"
                                            data-bs-target="#modalReset" href="">
                                            <i class="fas fa-sync-alt text-success p-1 bs-tooltip-top" data-toggle="tooltip"
                                                title="Reset password"></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <a class="editbtn" onclick="editAccount({{ $lineman->id }})"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit" href="">
                                            <i class="fas fa-user-edit text-primary p-1 bs-tooltip-top"
                                                data-toggle="tooltip" title="Edit"></i>
                                        </a>
                                    </td>

                                    <td class="">
                                        <a id="delbtn" class="deletebtn" data-bs-toggle="modal"
                                            data-bs-target="#modalDelete" onclick="deleteAccount({{ $lineman->id }})"
                                            href="">
                                            <i class="fas fa-trash text-danger p-1 bs-tooltip-top" data-toggle="tooltip"
                                                title="Delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    @if ($errors->has('email'))
        <script>
            $(document).ready(function() {
                $('#modalRegisterForm').modal('show');
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {

            // $.fn.dataTable.ext.classes.sPageButton = 'btn';
            var table = $('#table').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                'columnDefs': [{
                    'targets': [4, 5, 6],
                    'orderable': false,
                }],
                "pagingType": "simple_numbers",
            });

            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });

            $('[data-toggle="tooltip"]').tooltip();
        });

        function deleteAccount(id) {
            $('#delete-id').attr('action', `lineman/${id}`);
        }

        function resetPassword(id) {
            $.ajax({
                type: 'get',
                url: `lineman/${id}`,
                dataType: 'json',
                success: function(data) {
                    $('input#resetEmail').val(data.email);
                    $("#reset-id").submit(function(event) {
                        event.preventDefault();
                        $.ajax({
                            type: 'post',
                            url: `lineman/${data.id}/reset`,
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(data) {
                                if (data === "0") {
                                    $('#modal-content').css({
                                        'border-color': 'red',
                                        'border-width': '2px',
                                    });

                                    $('#text-msg').css({
                                        'color': 'red'
                                    });

                                    setTimeout(function() {
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

                                    setTimeout(function() {
                                        location.reload();
                                    }, 0);
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
                success: function(data) {
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
