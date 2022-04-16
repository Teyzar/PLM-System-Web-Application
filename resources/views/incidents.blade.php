@extends('layouts.app')


@section('head')
    {{-- <link rel="stylesheet" href="{{ mix('css/incidents.css') }}"> --}}
    <script src="{{ asset('libs/tippy.js/tippy.all.min.js') }}"></script>
    <script>
        let map, markers;

        var cadiz = {
            'lat': 10.95583493620157,
            'lng': 123.30611654802884
        };

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: cadiz,
                mapTypeId: "roadmap"
            });

            markers = [];
        }

        function addMarker(position, label) {
            markers.push(new google.maps.Marker({
                map,
                label,
                position,
                collisionBehavior: google.maps.CollisionBehavior.REQUIRED_AND_HIDES_OPTIONAL
            }));
            google.maps.event.addListener(markers, "click", function(event) {
                toggleBounce()
                showInfo(position);
            });
        }


        function areas(units) {
            console.log(units);

            for (const unit of units) {
                const position = {
                    lat: parseFloat(unit.latitude),
                    lng: parseFloat(unit.longitude)
                };
                map.panTo(position);
                addMarker(position, `${unit.id}`);
            }
        }

        function showInfo(latlng) {
            console.log(latlng);
            geocoder.geocode({
                'latLng': latlng
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        // here assign the data to asp lables
                        document.getElementById('<%=addressStandNo.ClientID %>').value = results[1]
                            .formatted_address;
                    } else {
                        alert('No results found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
        }

        // function updateMarker(id) {

        //     const unit = units.find(unit => unit.id == id);
        //     const checkbox = document.getElementsByName(`unit_ids[${id}]`)[0];

        //     if (!unit || !checkbox) return;

        //     const position = {
        //         lat: parseFloat(unit.latitude),
        //         lng: parseFloat(unit.longitude)
        //     };


        //     if (checkbox.checked) {
        //         map.panTo(position);
        //         addMarker(position, `${id}`);
        //     } else {
        //         map.panTo(cadiz);
        //         removeMarker(position);
        //     }
        // }
    </script>
@endsection

@section('content')
    <div class="container-fluid pt-3 mb-5">

        @if (count($incidents) <= 0)
            <div class="container-fluid">

                <div class="justify-content-center d-flex">
                    <i class="fe-calendar fs-1 text-dark"></i>
                </div>
                <div class="justify-content-center d-flex">

                    <span class="h4 text-primary">No published incidents.</span>
                </div>

            </div>
        @endif
        <div class="row">
            @foreach ($incidents as $incident)
                <span class="anchor" id="{{ $incident->id }}"></span>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body shadow">
                            @auth
                                <div class="dropdown float-end">

                                    <a id="dotIcon{{ $incident->id }}" href="#" class="dropdown-toggle card-drop arrow-none"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal m-0 text-muted h3"></i>
                                    </a>
                                    <div id="cancelbtn{{ $incident->id }}"></div>


                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item text-success" href="#"
                                            onclick="addIncident({{ $incident->id }})"><i
                                                class="mdi mdi-plus-box fs-5 pe-1"></i><span>Add Info</span></a>
                                        <a class="dropdown-item text-info" href="#"
                                            onclick="editIncident({{ $incident->id }})"><i
                                                class="fe-edit pe-1"></i><span>Edit Info</span></a>
                                        <a class="dropdown-item text-danger" type="button"
                                            onclick="passID({{ $incident->id }})" data-bs-toggle="modal"
                                            data-bs-target="#RemoveIncident">
                                            <i class="fe-delete pe-1"></i><span>Remove</span></a>
                                    </div>
                                </div> <!-- end dropdown -->
                            @endauth

                            <a href="#{{ $incident->id }}" class="text-muted">
                                <h5 class="mt-0">
                                    <span class="text-secondary">
                                        {{ \Carbon\Carbon::parse($incident->created_at)->toDayDateTimeString() }}
                                    </span>
                                </h5>
                            </a>

                            <hr>

                            <div id="info-body{{ $incident->id }}"></div>

                            @foreach ($incident->info as $info)
                                <span class="anchor" id="{{ $incident->id }}-{{ $info->id }}"></span>

                                <div>
                                    <a href="#{{ $incident->id }}-{{ $info->id }}" class="text-muted">
                                        <span id="title{{ $info->id }}" class="text-capitalize fw-bolder h5 mt-0">
                                            {{ $info->title }}
                                            <i class="fe-minus"></i>
                                        </span>
                                    </a>
                                    <span id="input-description{{ $info->id }}" class="">
                                        {{ $info->description }}
                                    </span>
                                    <div id="_editIcon{{ $info->id }}" class="float-end"></div>
                                </div>

                                <p class="mt-2">
                                    <span class="text-muted">
                                        {{ \Carbon\Carbon::parse($info->created_at)->toDayDateTimeString() }}
                                    </span>
                                </p>
                            @endforeach

                            <div id="incident{{ $incident->id }}" class="col-9 mb-3"></div>
                            <div id="textarea{{ $incident->id }}" class="col-9 mb-3"></div>

                            <div id="savebtn{{ $incident->id }}" class="float-end"></div>

                            <hr>

                            <span class="text-capitalize fw-bold h5 mt-0">
                                Areas Affected: <a type="button" onclick="areas({{ $incident->units }})"
                                    data-bs-toggle="modal" data-bs-target="#map-modal" class="text-info"><i
                                        type="button" class="fe-map fs-5" title="View Map" tabindex="0"
                                        data-plugin="tippy" data-tippy-placement="right"></i></a>
                            </span>
                            <ul>
                                @foreach ($incident->locations as $location)
                                    <li>
                                        <a class="text-muted">
                                            <span class="text-capitalize h6">
                                                {{ $location['city'] }}
                                                <i class="fe-minus"></i>
                                            </span>
                                        </a>

                                        <span class="fs-6">
                                            {{ implode(', ', $location['barangays']->toArray()) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div> <!-- end card box-->
                </div><!-- end col-->
            @endforeach
        </div>
    </div>

    <script src="{{ mix('js/incidents.js') }}"> </script>

    @auth
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
    @endauth
    @include('modals.incidents')
@endsection

@section('script')
    <script src="{{ asset('js/vendor.min.js') }}"></script>
@endsection
