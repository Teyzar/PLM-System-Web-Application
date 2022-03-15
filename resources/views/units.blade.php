@extends('layouts.app')



@section('head')
    <link href="{{ mix('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ mix('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ mix('libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ mix('css/config/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />


    <!-- App css -->
    {{-- <link href="{{ mix('css/config/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ mix('css/config/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" /> --}}

    <link href="{{ mix('css/units.css') }}" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection


@section('content')
    <div class="container-fluid mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-sm btn-blue waves-effect waves-light float-end fs-5"
                        data-bs-toggle="modal" data-bs-target="#store-unit" data-toggle="tooltip">
                        <i class="mdi mdi-plus-circle pe-1"></i> Register
                    </button>
                    <h4 class="header-title mb-4">Units</h4>

                    <div class="table-responsive">
                        <table class="table table-hover m-0 table-cente#f1556c dt-responsive nowrap w-100"
                            id="datatable-buttons">
                            {{-- or tickets-table --}}
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Status</th>
                                    <th>Mobile #</th>
                                    <th>Longitude</th>
                                    <th>Latitude</th>
                                    <th>Updated&nbsp;Last</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($units as $unit)
                                    <tr>
                                        <td>
                                            {{ $unit->id }}
                                        </td>
                                        <td>
                                            {{ Str::ucfirst($unit->status) }}
                                        </td>
                                        <td>
                                            {{ $unit->phone_number }}
                                        </td>

                                        <td>
                                            {{ $unit->longitude }}
                                        </td>

                                        <td>
                                            {{ $unit->latitude }}
                                        </td>

                                        <td>
                                            {{ $unit->updated_at }}
                                        </td>
                                        <td>
                                            <button id="delbtn" class="btn border-0 deletebtn float-end p-0"
                                                onclick="removeUnit({{ $unit->id }})" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalRemove">
                                                <i class="fas fa-trash fs-5 text-danger bs-tooltip-top tooltip-arrow"
                                                    data-toggle="tooltip" data-bs-placement="top" title="Remove"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
        <script>
            $(document).ready(function() {
                var submitbtn = $('#submitbtn');
                var phone_num = $('#phone_number');
                var closebtn = $('#close');
                var bar = $('#bar');
                var processing = $('#processing');
                var steps_bar = $('#steps-id');
                var spinner1 = $('#spinner1');
                var spinner2 = $('#spinner2');
                var spinner3 = $('#spinner3');
                var form = $('#unit-form');
                var line1 = $('#line1');
                var line2 = $('#line2');
                var start = $('#start');
                var controller = $('#controller');
                var message = $('#message');
                var pmessage = $('#p-message');

                steps_bar.hide();

                form.on('submit', function(e) {
                    e.preventDefault();
                    start.css('background', 'white');
                    controller.css('background', 'white');
                    message.css('background', 'white');
                    line1.css('background', 'white');
                    line2.css('background', 'white');

                    phone_num.attr('class', 'form-control')
                    pmessage.html('');

                    $.ajax({
                        type: "post",
                        url: "units",
                        data: $(this).serialize(),
                        dataType: 'json',
                        error: function(error) {
                            const errors = error.responseJSON?.errors?.phone_number;
                            if (Array.isArray(errors)) {
                                let output = "";
                                for (const message of errors) {
                                    if (output.length > 0) output += "</br>"
                                    output += `<strong>${message}</strong>`;
                                }

                                phone_num.attr('class', 'form-control is-invalid')
                                pmessage.html(output);

                                steps_bar.hide();
                                submitbtn.show();
                            }
                        },
                    });
                });

                Echo.channel("UnitRegister").listen("UnitRegisterUpdate", (data) => {
                    switch (data.message) {
                        case "start":
                            steps_bar.show('slow');
                            submitbtn.hide();

                            controller.css('background', 'white');
                            spinner1.html(`<div class="spinner-border text-secondary" role="status" style="margin-top: 2px">
                            <span class="sr-only">Loading...</span>
                            </div>`);
                            break;
                        case "published":
                            start.css('background', '#63d19e');
                            spinner1.html(
                                '<i class="mdi mdi-check"></i>');
                            line1.css('background-color', '#63d19e');
                            spinner2.html(`<div class="spinner-border text-secondary" role="status" style="margin-top: 2px">
                                    <span class="sr-only">Loading...</span>
                                    </div>`);
                            break;
                        case "controller 1":
                            controller.css('background', '#63d19e');
                            spinner2.html(
                                '<i class="mdi mdi-check"></i>');
                            line2.css('background-color', '#63d19e');
                            spinner3.html(`<div class="spinner-border text-secondary" role="status" style="margin-top: 2px">
                                    <span class="sr-only">Loading...</span>
                                    </div>`);
                            break;
                        case "controller 0":
                            submitbtn.show();
                            controller.css('background', '#f1556c');
                            spinner2.html(
                                '<i class="mdi mdi-alert-rhombus fs-4"></i>');
                            submitbtn.html('re-submit');
                            break;
                        case "message 1":
                            message.css('background', '#63d19e');
                            spinner3.html(
                                '<i class="mdi mdi-check fs-5"></i>');
                            location.reload();
                            break;
                        case "message 0":
                            submitbtn.show();
                            message.css('background', '#f1556c');
                            spinner3.html(
                                '<i class="mdi mdi-alert-rhombus fs-4"></i>');
                            submitbtn.html('re-submit');

                            spinner3.addClass('resubmit');
                            break;
                    }
                });
            });

            function removeUnit(id) {
                $('#remove-id').attr('action', `units/${id}`);
            }
        </script>
    </div>
    <style>
        body {
            overflow-y: hidden;
        }

    </style>

    @include('modals.units')

@section('script')
    <script src="{{ mix('js/vendor.min.js') }}"></script>
    <script src="{{ mix('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ mix('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ mix('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ mix('libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ mix('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ mix('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ mix('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ mix('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ mix('js/pages/datatables.init.js') }}"></script>
    {{-- <script src="{{ asset('libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('libs/datatables.net-select/js/dataTables.select.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script> --}}
@endsection
@endsection
