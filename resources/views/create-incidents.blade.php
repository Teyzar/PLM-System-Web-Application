@extends('layouts.app')

@section('head')
    <link href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />

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

        function updateMarker(id) {
            const units = {!! $units !!};
            const unit = units.find(unit => unit.id === id);
            const position = {
                lat: unit.latitude,
                lng: unit.longitude
            };
            const checkbox = document.getElementsByName(`unit_ids[${id}]`)[0];
            const removeMarker = () => {
                const newMarker = [];

                for (const marker of markers) {
                    const sameLat = marker.position.lat() === position.lat;
                    const sameLng = marker.position.lng() === position.lng;

                    if (sameLat && sameLng) {
                        marker.setMap(null);
                    } else {
                        newMarker.push(marker);
                    }
                }

                markers = newMarker;
            }
            const addMarker = () => {
                const marker = new google.maps.Marker({
                    map,
                    position
                });

                markers.push(marker);
            }

            if (!unit || !checkbox) return;

            if (checkbox.checked) {
                addMarker();
            } else {
                removeMarker();
            }
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('content')
    <form action="/past-incidents" method="POST">
        @csrf
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="container-fluid">
                                    <div class="mb-3">
                                        <label for="projectname" class="form-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="title" class="form-control" placeholder="Enter Title"
                                            name="title" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"> Title Description <span
                                                class="text-danger">*</span></label>
                                        {{-- <div id="snow-editor" style="height: 200px;">

                                        </div> --}}
                                        <textarea class="form-control" id="description" rows="5" placeholder="Enter some brief about the report.."
                                            name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <label class="form-label">Units - Fault <span class="text-danger">*</span></label>
                            <div class="table-responsive">
                                <table class="table table-hover m-0 table-cente#f1556c dt-responsive nowrap w-100"
                                    id="basic-datatable">
                                    {{-- or tickets-table --}}
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="" id="checkbox"></th>
                                            <th>ID</th>
                                            <th>Status</th>
                                            <th>Mobile #</th>
                                            <th>Longitude</th>
                                            <th>Latitude</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($units as $unit)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="unit_ids[{{ $unit->id }}]"
                                                        onchange="updateMarker({{ $unit->id }})">
                                                </td>
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
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div id="map" style="height: calc(82.7vh - 71px);"></div>
                        <script src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initMap&v=weekly&libraries=visualization"
                                                async>
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <button type="button" class="btn w-sm btn-light waves-effect">Cancel</button>
                    <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Save</button>
                    <button type="button" class="btn w-sm btn-danger waves-effect waves-light">Delete</button>
                </div>
            </div> <!-- end col -->
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
@endsection

@section('script')
    <script src="{{ mix('js/vendor.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('libs/quill/quill.min.js') }}"></script>
    <script src="{{ mix('js/pages/form-fileuploads.init.js') }}"></script>
    <script src="{{ mix('js/pages/add-product.init.js') }}"></script>
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
@endsection
