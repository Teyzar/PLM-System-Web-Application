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
                lat: parseFloat(unit.latitude),
                lng: parseFloat(unit.longitude)
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

        function checkFields() {
            const btnPublish = document.getElementById('btnPublish');
            const inptTitle = document.getElementById('title');
            const inptDescription = document.getElementById('description');

            if (inptTitle.value && inptDescription.value && markers.length > 0) {
                btnPublish.disabled = false;
            } else {
                btnPublish.disabled = true;
            }
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('content')
    <form action="/incidents" method="POST">
        @csrf
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="container-fluid">
                                    <div class="mb-3">
                                        <label for="projectname" class="form-label">
                                            Title
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input id="title" name="title" type="text"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Enter Title" oninput="checkFields()" required>

                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Description
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5"
                                            placeholder="Enter some brief description about the report"
                                            oninput="checkFields()" required></textarea>

                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <label class="form-label">
                                Units
                                <span class="text-danger">*</span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-hover m-0 table-cente#f1556c dt-responsive nowrap w-100"
                                    id="basic-datatable">
                                    {{-- or tickets-table --}}
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="" id="checkbox"></th>
                                            <th>Id</th>
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
                                                        onchange="updateMarker({{ $unit->id }}); checkFields();">
                                                </td>
                                                <td> {{ $unit->id }} </td>
                                                <td> {{ Str::ucfirst($unit->status) }} </td>
                                                <td> {{ $unit->phone_number }} </td>
                                                <td> {{ $unit->longitude }} </td>
                                                <td> {{ $unit->latitude }} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @error('unit_ids')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>At least 1 unit must be selected.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div id="map" style="height: calc(75vh - 71px);"></div>
                        <script src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initMap&v=weekly&libraries=visualization"
                                                async>
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="d-flex justify-content-center mb-5">
                <button id="btnPublish" type="submit" class="border-0 btn btn-success px-5" disabled>Publish</button>
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
