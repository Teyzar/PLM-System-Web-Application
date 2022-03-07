@extends('layouts.app')

@section('title', '- Dispatch')

@section('head')
    <link href="{{ mix('css/units.css') }}" rel="stylesheet">
    <link href="{{ mix('css/dispatch.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
@endsection

@section('content')
    <form method="POST" action="/dispatch" class="form-container" id="formid">
        @csrf
        <div id="" style="margin-left: 4%; margin-right: 4%;" class="mt-3 border-css">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col card-header border-end inner-menu shadow">Units</div>
                    <div class="col card-header border-start inner-menu shadow">Lineman</div>
                    <div class="w-100"></div>
                    <div class="col-6 card-body bg-light inner-menu shadow border-end">
                        <div class="table-responsive-md p-1">
                            <table id="table" class="table border client--nav-tabs">
                                <thead class="">
                                    <tr class="text-secondary tabs">
                                        <td scope="col" class="px-3"><input name="all" id="checkall-units"
                                                class="form-check-input" type="checkbox"></th>
                                        <th scope="col">Id</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Mobile #</th>
                                        <th scope="col">Longitude</th>
                                        <th scope="col">Latitude</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($units as $unit)
                                        <tr class="tabs text-dark" id="trunit">
                                            <td scope="col" class="px-3"><input id="unitid"
                                                    class="form-check-input cb-units" type="checkbox"
                                                    name="unit_no[{{ $unit->id }}]"></td>
                                            <td class="ps-3">{{ $unit->id }}</td>
                                            <td class="ps-3">{{ $unit->status }}</td>
                                            <td class="ps-3">{{ $unit->phone_number }}</td>
                                            <td class="ps-3">{{ $unit->longitude }}</td>
                                            <td class="ps-3">{{ $unit->latitude }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-6 card-body bg-light inner-menu shadow border-start">
                        <div class="table-responsive-md p-1">
                            <table id="table2" class="table border client--nav-tabs">
                                <thead>
                                    <tr class="text-secondary tabs">
                                        <td scope="col" class="px-3">
                                            <input name="all" id="checkall-lineman" class="form-check-input"
                                                type="checkbox">
                                            </th>
                                        <th scope="col">Name</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Designation</th>
                                    </tr>
                                </thead>
                                <tbody class="searchbody">
                                    @foreach ($linemans as $lineman)
                                        <tr class="text-dark tabs" id="trlineman">
                                            <td scope="col" class="px-3">
                                                <input id="linemanid" class="form-check-input cb-lineman" type="checkbox"
                                                    name="lineman_no[{{ $lineman->id }}]">
                                            </td>
                                            <td class="ps-3">{{ ucwords($lineman->name) }}</td>
                                            <td class="ps-3">{{ $lineman->email }}</td>
                                            <td class="ps-3">{{ ucwords($lineman->barangay) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content inner-menu shadow border-0 border-red">
                    <div class="modal-header">
                        <h6 class="modal-title text-secondary" id="exampleModalLabel">Confirmation</h6>
                    </div>
                    <div class="modal-body fs-6 text-black text-center p-4">
                        To despatch, select <span class="text-success">Yes.</span>
                    </div>
                    <div class="modal-footer border">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Close</button>
                        <button type="submit" class="btn btn-success" onclick="allPage()">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center pb-1 mt-5">
            <button id="btnDispatch" type="button" class="border-0 btn btn-secondary px-5" data-bs-toggle="modal"
                data-bs-target="#modalConfirm">Dispatch</button>
        </div>
    </form>

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
@endsection
