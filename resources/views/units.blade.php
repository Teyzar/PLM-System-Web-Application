@extends('layouts.app')



@section('head')
    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ mix('css/config/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />


    <!-- App css -->
    {{-- <link href="{{ mix('css/config/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ mix('css/config/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" /> --}}

    <link href="{{ mix('css/units.css') }}" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="{{ asset('libs/tippy.js/tippy.all.min.js') }}"></script>
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
                                    <th width="20%">Updated&nbsp;Last</th>
                                    <th width="1%">&nbsp;</th>
                                    <th width="1%">&nbsp;</th>
                                </tr>
                            </thead>
                            <div class="card">
                                <tbody>
                                    @foreach ($units as $unit)
                                        <tr>
                                            <td>
                                                {{ $unit->id }}
                                            </td>
                                            <td id="status{{ $unit->id }}" class="text-capitalize">
                                                {{ $unit->status }}
                                            </td>
                                            <td>
                                                {{ $unit->phone_number }}
                                            </td>

                                            <td id="long{{ $unit->id }}">
                                                {{ $unit->longitude }}
                                            </td>

                                            <td id="lat{{ $unit->id }}">
                                                {{ $unit->latitude }}
                                            </td>

                                            <td>
                                                {{ $unit->updated_at }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn border-0 float-end p-0">
                                                    <i id="ref-icon[{{ $unit->id }}]"
                                                        class="fe-refresh-ccw text-success fs-5" title="Refresh"
                                                        tabindex="0" data-plugin="tippy" data-tippy-placement="top"
                                                        onclick="updateUnit({{ $unit->id }})"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button id="delbtn" class="btn border-0 deletebtn float-end p-0"
                                                    onclick="removeUnit({{ $unit->id }})" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#modalRemove">
                                                    <i class="fe-trash text-danger fs-5" title="Remove" tabindex="0"
                                                        data-plugin="tippy" data-tippy-placement="top"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </div>
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
                var processing = $('#process');
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

                form.on('submit', function(e) {
                    e.preventDefault();
                    start.css('background', 'white');
                    controller.css('background', 'white');
                    message.css('background', 'white');
                    line1.css('background', 'white');
                    line2.css('background', 'white');
                    spinner1.html('<label class="text-muted">1</label>');
                    spinner2.html('<label class="text-muted">2</label>');
                    spinner3.html('<label class="text-muted">3</label>');
                    processing.html('');

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
                            submitbtn.attr('disabled', true);
                            submitbtn.html(
                                `
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`
                            );
                            processing.html(
                                '<label class="fs-5 pb-2 fw-bold text-success">Processing...</label>');

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
                            processing.html(
                                '<label class="fs-5 pb-2 text-success">Connected to Controller</label>'
                            );

                            spinner3.html(`<div class="spinner-border text-secondary" role="status" style="margin-top: 2px">
                                    <span class="sr-only">Loading...</span>
                                    </div>`);
                            break;
                        case "controller 0":
                            submitbtn.show();
                            processing.html(
                                '<label class="fs-5 pb-2 text-danger">There was an error connecting to controller..</label>'
                            );

                            controller.css('background', '#f1556c');
                            spinner2.html(
                                '<i class="mdi mdi-alert-rhombus fs-4"></i>');
                            submitbtn.html('re-send');
                            submitbtn.attr('disabled', false);

                            break;
                        case "message 1":
                            message.css('background', '#63d19e');
                            processing.html(
                                '<label class="fs-5 pb-2 text-success">Unit Registered Succesfully</label>'
                            );
                            spinner3.html(
                                '<i class="mdi mdi-check fs-5"></i>');
                            submitbtn.html('<i class="mdi mdi-send"></i>');

                            location.reload();
                            break;
                        case "message 0":
                            submitbtn.show();
                            message.css('background', '#f1556c');
                            processing.html(
                                '<label class="fs-5 pb-2 text-danger">There was an error during sending SMS</label>'
                            );
                            spinner3.html(
                                '<i class="mdi mdi-alert-rhombus fs-4"></i>');
                            submitbtn.html('re-send');
                            submitbtn.attr('disabled', false);
                            spinner3.addClass('resubmit');
                            break;
                    }
                });
            });


            function removeUnit(id) {
                $('#remove-id').attr('action', `units/${id}`);
            }
            function updateUnit(id) {
                var refresh = document.getElementById(`ref-icon[${id}]`);
                refresh.className = "fe-refresh-ccw text-success fs-5 rotate";
                setTimeout(() => {
                    refresh.className = "fe-refresh-ccw text-success fs-5";
                }, 1000);

                $.ajax({
                    type: 'get',
                    url: `/units/${id}/refresh`,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        $(`#status${id}`).html(data.status);
                        $(`#long${id}`).html(data.longitude);
                        $(`#lat${id}`).html(data.latitude);
                    }
                });
            }
        </script>

        <style>
            .fe-refresh-ccw {
                transform: rotate(0deg);
            }

            .fe-refresh-ccw.rotate {
                transform: rotate(2160deg);
                transition: transform 3s linear;
            }

        </style>

    </div>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> &copy; <span>Power Line Monitoring</span>
                </div>
                <div class="col-md-6">
                    <div class="text-md-end footer-links d-none d-sm-block">
                        <a href="/about">PLMS-CLZ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @include('modals.units')
@endsection
@section('script')
    <script src="{{ mix('js/vendor.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ mix('js/pages/datatables.init.js') }}"></script>

    {{-- <script src="{{ mix('libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script> --}}
    {{-- <script src="{{ mix('libs/datatables.net-select/js/dataTables.select.min.js') }}"></script> --}}
    {{-- <script src="{{ mix('libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script> --}}
    {{-- <script src="{{ mix('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script> --}}
@endsection
