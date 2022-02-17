@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/units.css') }}" rel="stylesheet">
    <link href="{{ mix('css/dispatch.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
@endsection

@section('content')
    <form method="POST" action="/dispatch" class="form-container">
        @csrf
        <div id="" style="margin-left: 4%; margin-right: 4%;" class="mt-3 border-css">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col card-header border inner-menu shadow">Units</div>
                    <div class="col card-header border inner-menu shadow">Lineman</div>
                    <div class="w-100"></div>
                    <div class="col-6 card-body border bg-light inner-menu shadow border border-black">
                        <div class="table-responsive-md p-1">
                            <table id="table"
                                class="table border mt-1 table-borderless cell compact tabs inner-menu shadow">
                                <thead>
                                    <tr class="text-secondary">
                                        <th scope="col" class="px-3"><input name="all" id="checkall-units"
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
                                        <tr class="text-dark">
                                            <td scope="col" class="px-3"><input class="form-check-input cb-units"
                                                    type="checkbox" name="unit_no[{{ $unit->id }}]"></td>
                                            <td scope="col">{{ $unit->id }}</td>
                                            <td scope="col">{{ $unit->active }}</td>
                                            <td scope="col">{{ $unit->phone_number }}</td>
                                            <td scope="col">{{ $unit->longitude }}</td>
                                            <td scope="col">{{ $unit->latitude }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-6 card-body border bg-light inner-menu shadow border border-black">
                        <div class="table-responsive-md p-1">
                            <table id="table2" class="table border table-borderless cell compact tabs inner-menu shadow">
                                <thead>
                                    <tr class="text-secondary">
                                        <th scope="col" class="px-3"><input name="all" id="checkall-lineman"
                                                class="form-check-input" type="checkbox"></th>
                                        <th scope="col">Name</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Designation</th>
                                    </tr>
                                </thead>
                                <tbody class="searchbody">
                                    @foreach ($linemans as $lineman)
                                        <tr class="text-dark">
                                            <th scope="col" class="px-3"><input
                                                    class="form-check-input cb-lineman" type="checkbox"
                                                    name="lineman_no[{{ $lineman->id }}]"></th>
                                            <td>{{ ucwords($lineman->name) }}</td>
                                            <td>{{ $lineman->email }}</td>
                                            <td>{{ ucwords($lineman->barangay) }}</td>
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
                        <button type="submit" class="btn btn-success" onclick="">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center pb-1 mt-5">
            <button type="button" disabled class="border-0 btn btn-secondary px-5" onclick="dispatchBtn()">Dispatch</button>
        </div>
    </form>

    <script>
        function dispatchBtn() {
            var checkedValueUnits = $('.cb-units:checked').val();
            var checkedValueLineman = $('.cb-lineman:checked').val();

            if (checkedValueUnits == "on" && checkedValueLineman == "on") {
                $('#modalConfirm').modal('show');
            } else if (checkedValueUnits != "on" || checkedValueLineman != "on") {
                $.toast({
                    text: '<p>To dispatch, you should choose units and lineman.</p>',
                    showHideTransition: 'slide',
                    bgColor: '#b71c1c',
                    textColor: '#eee',
                    stack: 3,
                    textAlign: 'left',
                    position: 'top-right'
                })
            }
        }

        //disable enter key keyboard when submitting
        $("form").bind("keypress", function(e) {
            if (e.keyCode == 13) {
                return false;
            }
        });
        $(document).ready(function() {
            $('#table').DataTable({
                "lengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],
            });


            $('#table2').DataTable({
                "lengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],
            });

            $('#checkall-units').change(function() {
                $('.cb-units').prop('checked', this.checked).css({
                    "transition": "0.3s all ease-in-out",
                });
            });

            $('#checkall-lineman').change(function() {
                $('.cb-lineman').prop('checked', this.checked).css({
                    "transition": "0.3s all ease-in-out",
                });
            });
        });
    </script>
@endsection
