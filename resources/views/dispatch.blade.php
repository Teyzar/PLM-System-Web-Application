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

            const darkMode = localStorage.getItem('darkMode');
            const darkModeButton = document.querySelector('#dark-mode-check');
            const lightModeButton = document.querySelector('#light-mode-check');

            const enableDarkMode = () => {
                map.setOptions({
                    styles: [{
                            elementType: "geometry",
                            stylers: [{
                                color: "#242f3e"
                            }]
                        },
                        {
                            elementType: "labels.text.stroke",
                            stylers: [{
                                color: "#242f3e"
                            }]
                        },
                        {
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#746855"
                            }]
                        },
                        {
                            featureType: "administrative.locality",
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#d59563"
                            }],
                        },
                        {
                            featureType: "poi",
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#d59563"
                            }],
                        },
                        {
                            featureType: "poi.park",
                            elementType: "geometry",
                            stylers: [{
                                color: "#263c3f"
                            }],
                        },
                        {
                            featureType: "poi.park",
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#6b9a76"
                            }],
                        },
                        {
                            featureType: "road",
                            elementType: "geometry",
                            stylers: [{
                                color: "#38414e"
                            }],
                        },
                        {
                            featureType: "road",
                            elementType: "geometry.stroke",
                            stylers: [{
                                color: "#212a37"
                            }],
                        },
                        {
                            featureType: "road",
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#9ca5b3"
                            }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "geometry",
                            stylers: [{
                                color: "#746855"
                            }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "geometry.stroke",
                            stylers: [{
                                color: "#1f2835"
                            }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#f3d19c"
                            }],
                        },
                        {
                            featureType: "transit",
                            elementType: "geometry",
                            stylers: [{
                                color: "#2f3948"
                            }],
                        },
                        {
                            featureType: "transit.station",
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#d59563"
                            }],
                        },
                        {
                            featureType: "water",
                            elementType: "geometry",
                            stylers: [{
                                color: "#17263c"
                            }],
                        },
                        {
                            featureType: "water",
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#515c6d"
                            }],
                        },
                        {
                            featureType: "water",
                            elementType: "labels.text.stroke",
                            stylers: [{
                                color: "#17263c"
                            }],
                        },
                    ]
                });
            };

            const enableLightMode = () => {
                map.setOptions({
                    styles: []
                });
            }

            if (darkMode === "enabled") {
                enableDarkMode();
            }

            darkModeButton.addEventListener('click', enableDarkMode);
            lightModeButton.addEventListener('click', enableLightMode);
        }


        function updateMarker(units, id) {
            $('form').attr('action', `/incidents/${id}/dispatch`);

            var radio = document.getElementById(`radio${id}`);
            var nxtbtn = document.getElementById('nextbtn');

            if (radio.checked) {
                nxtbtn.disabled = false;
            } else {
                nxtbtn.disabled = true;
            }

            for (const marker of markers) {
                marker.setMap(null);
            }

            markers = [];

            for (const unit of units) {

                var position = {
                    lat: parseFloat(unit.latitude),
                    lng: parseFloat(unit.longitude)
                };

                map.panTo(position);
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
    <form action="" method="POST">
        @csrf
        @method('GET')
        <div class="container-fluid mt-2">
            <div class="card" style="margin-bottom: 6%">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <h4 class="header-title">Incidents</h4>
                            <p class="sub-header">
                                Please select an incident.
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
                                        <tr class="text-center">
                                            <td>

                                                <input type="radio" id="radio{{ $incident->id }}" class="radio"
                                                    onclick="updateMarker({{ $incident->units()->get() }}, {{ $incident->id }})"
                                                    name="incident_id">
                                            </td>
                                            <td>
                                                {{ $incident->id }}
                                            </td>
                                            <td>
                                                {{ count($incident->units()->get()) }}

                                            </td>
                                            <td>
                                                {{ Carbon\Carbon::parse($incident->created_at)->toDayDateTimeString() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <div id="map" style="height: calc(75vh - 71px);" class="mb-3"></div>
                            <script src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initMap&v=beta&libraries=visualization"
                                                        async>
                            </script>
                        </div>
                    </div>
                    <div class="justify-content-center d-flex mt-3">
                        <button id="nextbtn" type="submit" class="btn btn-primary px-5 py-1" onclick="nextbtn()"
                            disabled>Next</a>
                    </div>
                </div>
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
    </footer><!-- end card-->
@endsection
@section('script')
    <script src="{{ mix('js/vendor.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-table/bootstrap-table.min.js') }}"></script>
    <script src="{{ mix('js/pages/bootstrap-tables.init.js') }}"></script>
@endsection
