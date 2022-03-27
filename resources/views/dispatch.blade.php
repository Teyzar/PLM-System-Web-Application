@extends('layouts.app')

@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link href="{{ asset('libs/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" /> --}}

    <script>
        let map, markers;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: {
                    'lat': 10.95583493620157,
                    'lng': 123.30611654802884
                },
                mapTypeId: "roadmap"
            });

            markers = [];
        }

        function updateMarker(units, id) {
            var checkbox = document.getElementsByClassName(`radio[${id}]`)[0];

            for (const marker of markers) {
                marker.setMap(null);
            }

            markers = [];

            for (const unit of units) {
                markers.push(new google.maps.Marker({
                    map,
                    label: `${unit.id}`,
                    position: {
                        lat: parseFloat(unit.latitude),
                        lng: parseFloat(unit.longitude)
                    },
                    collisionBehavior: google.maps.CollisionBehavior.REQUIRED_AND_HIDES_OPTIONAL
                }));
            }
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('content')
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Radio Select</h4>
                        <p class="sub-header">
                            Example of radio select.
                        </p>

                        <table data-toggle="table" data-page-size="10" data-buttons-class="xs btn-light"
                            data-pagination="true" class="table-bordered">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th></th>
                                    <th>Incident ID</th>
                                    <th>Number of Units</th>
                                    <th>Date Created</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($incidents as $incident)
                                    <form name="myForm">
                                        <tr class="text-center">
                                            <td>

                                                <input type="radio" id="radio{{ $incident->id }}" name="radio"
                                                    class="radio[{{ $incident->id }}]" value="{{ $incident->id }}"
                                                    onchange="updateMarker({{ $incident->units()->get() }}, {{ $incident->id }})">


                                            </td>
                                            <td>
                                                {{ $incident->id }}
                                            </td>
                                            <td>
                                                {{ count($incident->units()->get()) }}

                                            </td>
                                            <td>
                                                {{ $incident->created_at }}
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <table class="table table-hover m-0 table-cente#f1556c dt-responsive nowrap w-100"
                            id="basic-datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        &nbsp;
                                    </th>
                                    <th class="text-center">
                                        Incident ID
                                    </th>
                                    <th class="text-center">
                                        Number of Units
                                    </th>
                                    <th class="text-center">
                                        Date Created
                                    </th>
                                </tr>

                            </thead>

                            <tbody>
                                @foreach ($incidents as $incident)
                                    <tr>
                                        <td class="text-center">
                                            <input type="radio" onclick="updateMarker({{ $incident->units()->get() }})">
                                        </td>
                                        <td class="text-center">
                                            {{ $incident->id }}
                                        </td>
                                        <td class="text-center">
                                            {{ count($incident->units()->get()) }}

                                        </td>
                                        <td class="text-center">
                                            {{ $incident->created_at }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div id="map" style="height: calc(75vh - 71px);"></div>
                    <script src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initMap&v=beta&libraries=visualization"
                                        async>
                    </script>
                </div>
            </div>
            <div class="justify-content-center d-flex mt-3">
                <button class="btn btn-primary px-3 py-1">Next</button>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ mix('js/vendor.min.js') }}"></script>
    {{-- <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ mix('js/pages/datatables.init.js') }}"></script> --}}


    <script src="{{ asset('libs/bootstrap-table/bootstrap-table.min.js') }}"></script>
    <script src="{{ mix('js/pages/bootstrap-tables.init.js') }}"></script>
@endsection
