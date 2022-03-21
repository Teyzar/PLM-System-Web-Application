@extends('layouts.app')

@section('head')
    {{-- <link rel="stylesheet" href="{{ mix('css/incidents.css') }}"> --}}
@endsection

@section('content')
    <div class="container-fluid pt-3 mb-5">
        <div class="row">
            @foreach ($incidents as $incident)
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body shadow">
                            @auth
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle card-drop arrow-none" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal m-0 text-muted h3"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item text-info" href="#"><i
                                                class="fe-edit pe-1"></i><span>Edit</span></a>
                                        <a class="dropdown-item text-danger" type="button" onclick="passID({{ $incident->id }})"
                                            data-bs-toggle="modal" data-bs-target="#RemoveIncident">
                                            <i class="fe-delete pe-1"></i><span>Remove</span></a>
                                    </div>
                                </div> <!-- end dropdown -->
                            @endauth
                            <h5 class="mt-0"><span
                                    class="fw-bold fs-5">{{ \Carbon\Carbon::parse($incident->created_at)->toDayDateTimeString() }}</span>
                            </h5>
                            <hr>
                            @foreach ($incident->info()->get() as $info)
                                <span class="text-capitalize fw-bolder h5 mt-0">{{ $info->title }}</span> <i
                                    class="fe-minus"></i>
                                <span class="">{{ $info->description }}</span>
                                <p class="mt-2"><span
                                        class="text-muted">{{ \Carbon\Carbon::parse($info->created_at)->toDayDateTimeString() }}</span>
                                </p>
                            @endforeach

                        </div>
                    </div> <!-- end card box-->
                </div><!-- end col-->
            @endforeach
        </div>
    </div>

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
    <script>
        function passID(id) {
            console.log(id);
            $('#incident-form').attr('action', `/incidents/${id}`);
        }
    </script>
@endsection
