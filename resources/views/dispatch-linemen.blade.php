@extends('layouts.app')

@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <link href="{{ asset('libs/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />

    <script>
        function checkFields(id) {
            var checkbox = document.getElementById(`linemanid[${id}]`);

            var btn = document.getElementById('btnDispatch');
            if (checkbox.checked) {
                btn.disabled = false;
            } else {
                btn.disabled = true;
            }
        }

        function checkAll() {
            var checkall_btn = document.getElementById(`checkall-lineman`);
            var btn = document.getElementById('btnDispatch');

            if (checkall_btn.checked) {
                btn.disabled = false;
            } else {
                btn.disabled = true;
            }
        }
    </script>
@endsection

@section('content')
    <form action="/incidents/{{ $incident_id }}/dispatch" method="POST">
        @csrf
        <div class="container-fluid mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Kindly select a linemen to dispatch.</h4>

                    <div class="table-responsive">
                        <table class="table table-hover dt-responsive nowrap w-100 table-bordered" id="tickets-table">
                            <thead>
                                <tr>
                                    <th><input name="all" id="checkall-lineman" class="form-check-input" type="checkbox"
                                            onclick="checkAll()">
                                    </th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Designation</th>
                                    <th>Registration</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($linemen as $lineman)
                                    <tr>
                                        <td><input id="linemanid[{{ $lineman->id }}]" class="form-check-input cb-lineman"
                                                type="checkbox" name="lineman_ids[{{ $lineman->id }}]"
                                                onclick="checkFields({{ $lineman->id }})"></td>
                                        <td class="text-capitalize">{{ $lineman->name }}</td>
                                        <td>{{ $lineman->email }}</td>
                                        <td class="text-capitalize">{{ $lineman->barangay }}</td>
                                        <td>{{ \Carbon\Carbon::parse($lineman->created_at)->toDayDateTimeString() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="justify-content-center d-flex" style="margin-bottom: 6%">
                <button id="btnDispatch" type="submit" class="btn btn-primary px-5 py-1" disabled>Dispatch</a>
            </div>
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
                        <a href="/about">PLMS-CLZ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
@section('script')
    <script src="{{ mix('js/vendor.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>

    <script src="{{ mix('js/pages/tickets.js') }}"></script>

    <script>
        $(document).ready(function() {
            var linemanTable = $('#tickets-table').DataTable();

            var LinemanPages = linemanTable.cells().nodes();

            $('#checkall-lineman').change(function() {
                if ($(this).hasClass('cb-lineman')) {
                    $('.cb-lineman', LinemanPages).prop('checked', false).css({
                        "transition": "0.3s all ease-in-out",
                    });

                } else {
                    $('.cb-lineman', LinemanPages).prop('checked', true).css({
                        "transition": "0.3s all ease-in-out",
                    });
                }
                $(this).toggleClass('cb-lineman');
            });

            const assigned_linemen = {!! $assigned_linemen !!};
            for (const lineman of assigned_linemen) {
                var checkbox = document.getElementById(`linemanid[${lineman.id}]`);

                checkbox.classList.remove('cb-lineman');


                checkbox.checked = true;
                checkbox.disabled = true;
            }

        });
    </script>
@endsection
