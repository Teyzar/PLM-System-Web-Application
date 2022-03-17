@extends('layouts.app')

@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection


@section('content')

    <form method="POST" action="/dispatch" class="form-container" id="formid">
        @csrf
        <div class="container-fluid mt-4">
            <h5 class="text-secondary text-uppercase bg-light justify-content-center d-flex p-2">To dispatch, please select both sides.</h5>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="header-title mb-0">Units</h4>

                            <div id="cardCollpase5" class="collapse pt-3 show">
                                <div class="table-responsive">
                                    <table id="table" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th><input name="all" id="checkall-units" class="form-check-input"
                                                        type="checkbox"></th>
                                                <th>Id</th>
                                                <th>Status</th>
                                                <th>Mobile #</th>
                                                <th>Longitude</th>
                                                <th>Latitude</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            @foreach ($units as $unit)
                                                <tr class="" id="trunit">
                                                    <td><input id="unitid" class="form-check-input cb-units" type="checkbox"
                                                            name="unit_no[{{ $unit->id }}]"></td>
                                                    <td>{{ $unit->id }}</td>
                                                    <td>{{ $unit->status }}</td>
                                                    <td>{{ $unit->phone_number }}</td>
                                                    <td>{{ $unit->longitude }}</td>
                                                    <td>{{ $unit->latitude }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end table responsive-->
                            </div> <!-- collapsed end -->
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="header-title mb-0">Lineman</h4>

                            <div id="cardCollpase5" class="collapse pt-3 show">
                                <div class="table-responsive">
                                    <table id="table2" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input name="all" id="checkall-lineman" class="form-check-input"
                                                        type="checkbox">
                                                </th>
                                                <th>Name</th>
                                                <th>E-mail</th>
                                                <th>Designation</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            @foreach ($linemans as $lineman)
                                                <tr id="trlineman">
                                                    <td>
                                                        <input id="linemanid" class="form-check-input cb-lineman"
                                                            type="checkbox" name="lineman_no[{{ $lineman->id }}]">
                                                    </td>
                                                    <td>{{ ucwords($lineman->name) }}</td>
                                                    <td>{{ $lineman->email }}</td>
                                                    <td>{{ ucwords($lineman->barangay) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end table responsive-->
                            </div> <!-- collapsed end -->
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
        </div>

        <div class="modal fade" id="modalConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content inner-menu shadow">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Confirmation</h6>
                    </div>
                    <div class="modal-body text-center p-4">
                        To dispatch, select <span class="text-success">Yes.</span>
                    </div>
                    <div class="modal-footer border">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Close</button>
                        <button type="submit" class="btn btn-success" onclick="allPage()">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center pb-1">
            <button id="btnDispatch" type="button" class="border-0 btn btn-success px-5" data-bs-toggle="modal"
                data-bs-target="#modalConfirm">Dispatch</button>
        </div>
    </form>
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
                        <a href="javascript:void(0);">PLMS-CLZ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

@section('script')
    <!-- Bootstrap Tables js -->
    <script src="{{ mix('js/vendor.min.js') }}"></script>

    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>




    <script>
        $("form").bind("keypress", function(e) {
            if (e.keyCode == 13) {
                return false;
            }
        });

        function allPage() {
            var linemanTable = $('#table2').DataTable();
            var unitTable = $('#table').DataTable();
            linemanTable.page.len(-1).draw();
            unitTable.page.len(-1).draw();
        }

        function selectRow(row) {
            var firstInput = row.getElementsByTagName('input')[0];
            firstInput.checked = !firstInput.checked;
        }

        $(document).ready(function() {

            document.getElementById('btnDispatch').disabled = true;

            var unitTable = $('#table').DataTable({
                "lengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],
                'columnDefs': [{
                    'targets': [0],
                    'orderable': false, // orderable false
                }]
            });
            var linemanTable = $('#table2').DataTable({
                "lengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],
                'columnDefs': [{
                    'targets': [0],
                    'orderable': false, // orderable false
                }]
            });

            var LinemanPages = linemanTable.cells().nodes();
            var UnitPages = unitTable.cells().nodes();
            $('#checkall-lineman').change(function() {
                if ($(this).hasClass('cb-lineman')) {
                    $('input[type="checkbox"]', LinemanPages).prop('checked', false).css({
                        "transition": "0.3s all ease-in-out",
                    });

                } else {
                    $('input[type="checkbox"]', LinemanPages).prop('checked', true).css({
                        "transition": "0.3s all ease-in-out",
                    });
                }
                $(this).toggleClass('cb-lineman');
            });

            $('#checkall-units').change(function() {
                if ($(this).hasClass('cb-units')) {
                    $('input[type="checkbox"]', UnitPages).prop('checked', false).css({
                        "transition": "0.3s all ease-in-out",
                    });
                } else {
                    $('input[type="checkbox"]', UnitPages).prop('checked', true).css({
                        "transition": "0.3s all ease-in-out",
                    });
                }
                $(this).toggleClass('cb-units');
            });
        });

        $("#checkall-units, #checkall-lineman").on('click', function() {
            var allunit = $('#checkall-units:checked').val();
            var alllineman = $('#checkall-lineman:checked').val();

            if (allunit == "on" && alllineman == "on") {
                document.getElementById('btnDispatch').disabled = false;
            } else {
                document.getElementById('btnDispatch').disabled = true;
            }
        });
        $("#checkall-units, .cb-lineman").on('click', function() {
            var allunit = $('#checkall-units:checked').val();
            var lineman = $('.cb-lineman:checked').val();

            if (allunit == "on" && lineman == "on") {
                document.getElementById('btnDispatch').disabled = false;
            } else {
                document.getElementById('btnDispatch').disabled = true;
            }
        });
        $("#checkall-lineman, .cb-units").on('click', function() {
            var alllineman = $('#checkall-lineman:checked').val();
            var unit = $('.cb-units:checked').val();

            if (alllineman == "on" && unit == "on") {
                document.getElementById('btnDispatch').disabled = false;
            } else {
                document.getElementById('btnDispatch').disabled = true;
            }
        });
        $(".cb-units, .cb-lineman").on('click', function() {
            var lineman = $('.cb-lineman:checked').val();
            var unit = $('.cb-units:checked').val();
            if (lineman == "on" && unit == "on") {
                document.getElementById('btnDispatch').disabled = false;
            } else {
                document.getElementById('btnDispatch').disabled = true;
            }
        });
    </script>



    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script> --}}
@endsection

@endsection
