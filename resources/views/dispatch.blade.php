@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/units.css') }}" rel="stylesheet">
    <link href="{{ mix('css/dispatch.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
@endsection

@section('content')
    <form method="POST" action="/dispatch">
        @csrf
        <div style="margin-left: 4%; margin-right: 4%;">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="d-flex justify-content-end pb-1">
                        <button type="submit" class="border-0 btn btn-primary px-3">Dispatch</button>
                    </div>
                    <div class="col card-header bg-light border">Units</div>
                    <div class="col card-header bg-light border">Lineman</div>
                    <div class="w-100"></div>
                    <div class="col-6 card-body border bg-light">
                        {{-- <div class="has-search mt-1 col-md-6">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control rounded d-flex" placeholder="Search" name="search">
                        </div> --}}
                        <div class="table-responsive">
                            <table id="table" class="table border-0 mt-1 table-responsive table-borderless">
                                <thead>
                                    <tr class="text-secondary">
                                        <th scope="col" width="0%"><input name="all" id="checkall-units"
                                                class="form-check-input" type="checkbox"></th>
                                        <th scope="col" width="5%">Id</th>
                                        <th scope="col" width="15%">Status</th>
                                        <th scope="col" width="25%">Mobile #</th>
                                        <th scope="col" width="25%">Longitude</th>
                                        <th scope="col" width="25%">Latitude</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($units as $unit)
                                        <tr>
                                            <th scope="row"><input class="form-check-input cb-units" type="checkbox"
                                                    name="unit_no[{{ $unit->id }}]"></th>
                                            <td>{{ $unit->id }}</td>
                                            <td>{{ $unit->active }}</td>
                                            <td><i class="fa fa-check-circle-o green"></i><span
                                                    class="ms-1">{{ $unit->phone_number }}</span></td>
                                            <td>{{ $unit->longitude }}</td>
                                            <td>{{ $unit->latitude }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-6 card-body border bg-light">
                        {{-- <div class="has-search mt-1 col-md-6">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control rounded d-flex" placeholder="Search" name="search"
                                id="search">
                        </div> --}}
                        <div class="table-responsive">
                            <table id="table2" class="table mt-1 table-responsive table-borderless">
                                <thead>
                                    <tr class="text-secondary">
                                        <th scope="col" width="5%"><input name="all" id="checkall-lineman"
                                                class="form-check-input" type="checkbox"></th>
                                        <th scope="col" width="25%">Name</th>
                                        <th scope="col" width="25%">E-mail</th>
                                        <th scope="col" width="20%">Designation</th>
                                    </tr>
                                </thead>
                                <tbody class="searchbody">
                                    @foreach ($linemans as $lineman)
                                        <tr>
                                            <th scope="row"><input class="form-check-input cb-lineman" type="checkbox"
                                                    name="lineman_no[{{ $lineman->id }}]"></th>
                                            <td>{{ $lineman->name }}</td>
                                            <td>{{ $lineman->email }}</td>
                                            <td><i class="fa fa-check-circle-o green"></i><span
                                                    class="ms-1">{{ $lineman->barangay }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- <div class="d-flex justify-content-center p-3 pagination">
                        {!! $linemans->links() !!}
                    </div> --}}
                </div>
            </div>
        </div>
    </form>

    <script>
        //disable enter key keyboard when submitting
        $("form").bind("keypress", function(e) {
            if (e.keyCode == 13) {
                return false;
            }
        });

        $(document).ready(function() {

            $('#table').DataTable({
                "lengthMenu": [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ]
            });

            $('#table2').DataTable({
                "lengthMenu": [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ]
            });

            $('#checkall-units').change(function() {
                $('.cb-units').prop('checked', this.checked);
            });

            $('.cb-units').change(function() {
                if ($('.cb-units:checked').length == $('.cb-units').length) {
                    $('#checkall-units').prop('checked', true);
                } else {
                    $('#checkall-units').prop('checked', false);
                }
            });

            $('#checkall-lineman').change(function() {
                $('.cb-lineman').prop('checked', this.checked);
            });

            $('.cb-lineman').change(function() {
                if ($('.cb-units:checked').length == $('.cb-lineman').length) {
                    $('#checkall-lineman').prop('checked', true);
                } else {
                    $('#checkall-lineman').prop('checked', false);
                }
            });

            $('[data-toggle="tooltip"]').tooltip();
            try {
                $('input#search').on('keyup', function() {
                    $value = $(this).val();
                    $.ajax({
                        type: 'get',
                        url: 'dispatch-lineman-search',
                        data: {
                            'searchTerm': $value
                        },
                        dataType: 'json',
                        success: function(data) {
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
    </script>
@endsection
