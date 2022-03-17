@extends('layouts.app')

@section('head')
    {{-- <link rel="stylesheet" href="{{ mix('css/incidents.css') }}"> --}}
@endsection

@section('content')
    <div class="container-fluid pt-3 mb-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card project-box">
                    <div class="card-body">
                        @auth
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle card-drop arrow-none" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal m-0 text-muted h3"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item text-info" href="#"><i
                                            class="fe-edit pe-1"></i><span>Edit</span></a>
                                    <a class="dropdown-item text-danger" href="#"><i
                                            class="fe-delete pe-1"></i><span>Remove</span></a>
                                </div>
                            </div> <!-- end dropdown -->
                        @endauth
                        <!-- Title-->
                        <h5 class="mt-0"><a href="project-detail.html" class="text-dark">March 12,
                                2022</a>
                        </h5>
                        <div class="w-100 border mb-2"></div>
                        <p class="text-muted"><i class="fe-corner-down-right"></i> <small
                                class="text-uppercase fw-bold">Resolved </small> - <mark>This incident has
                                been
                                resolved</mark></p>
                        <p class="text-muted"><i class="ps-2"></i><small
                                class="badge bg-soft-success text-secondary mb-3">March, 12 2022
                                10:25am</small></p>

                        <p class="text-muted"><i class="fe-corner-down-right"></i> <small
                                class="text-uppercase fw-bold">Investigating </small> - <mark>We are
                                currently investigating
                                a latency message and messages send issued for some requests</mark></p>
                        <p class="text-muted"><i class="ps-2"></i><small
                                class="badge bg-soft-success text-secondary mb-3">March, 12 2022
                                8:15am</small></p>

                    </div>
                </div> <!-- end card box-->
            </div><!-- end col-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card project-box">
                    <div class="card-body">
                        @auth
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle card-drop arrow-none" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal m-0 text-muted h3"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item text-info" href="#"><i
                                            class="fe-edit pe-1"></i><span>Edit</span></a>
                                    <a class="dropdown-item text-danger" href="#"><i
                                            class="fe-delete pe-1"></i><span>Remove</span></a>
                                </div>
                            </div> <!-- end dropdown -->
                        @endauth
                        <!-- Title-->
                        <h5 class="mt-0"><a href="project-detail.html" class="text-dark">March 12,
                                2022</a>
                        </h5>
                        <div class="w-100 border mb-2"></div>

                        <p class="text-muted"><i class="fe-corner-down-right"></i> <small
                                class="text-uppercase fw-bold">Investigating </small> - <mark>We are
                                currently investigating
                                a latency message and messages send issued for some requests</mark></p>
                        <p class="text-muted"><i class="ps-2"></i><small
                                class="badge bg-soft-success text-secondary mb-3">March, 12 2022
                                8:15am</small></p>

                    </div>
                </div> <!-- end card box-->
            </div><!-- end col-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card project-box">
                    <div class="card-body">
                        @auth
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle card-drop arrow-none" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal m-0 text-muted h3"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item text-info" href="#"><i
                                            class="fe-edit pe-1"></i><span>Edit</span></a>
                                    <a class="dropdown-item text-danger" href="#"><i
                                            class="fe-delete pe-1"></i><span>Remove</span></a>
                                </div>
                            </div> <!-- end dropdown -->
                        @endauth
                        <!-- Title-->
                        <h5 class="mt-0"><a href="project-detail.html" class="text-dark">March 9,
                                2022</a>
                        </h5>
                        <div class="w-100 border mb-2"></div>
                        <p class="text-muted"><i class="fe-corner-down-right"></i> <small
                                class="text-uppercase fw-bold">Resolved </small> - <mark>This incident has
                                been
                                resolved</mark></p>
                        <p class="text-muted"><i class="ps-2"></i><small
                                class="badge bg-soft-success text-secondary mb-3">March, 9 2022
                                9:15am</small></p>

                        <p class="text-muted"><i class="fe-corner-down-right"></i> <small
                                class="text-uppercase fw-bold">Investigating </small> - <mark>We are
                                currently investigating
                                a latency message and messages send issued for some requests</mark></p>
                        <p class="text-muted"><i class="ps-2"></i><small
                                class="badge bg-soft-success text-secondary mb-3">March, 9 2022
                                8:15am</small></p>

                    </div>
                </div> <!-- end card box-->
            </div><!-- end col-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card project-box">
                    <div class="card-body">
                        @auth
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle card-drop arrow-none" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal m-0 text-muted h3"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item text-info" href="#"><i
                                            class="fe-edit pe-1"></i><span>Edit</span></a>
                                    <a class="dropdown-item text-danger" href="#"><i
                                            class="fe-delete pe-1"></i><span>Remove</span></a>
                                </div>
                            </div> <!-- end dropdown -->
                        @endauth
                        <!-- Title-->
                        <h5 class="mt-0"><a href="project-detail.html" class="text-dark">March 9,
                                2022</a>
                        </h5>
                        <div class="w-100 border mb-2"></div>

                        <p class="text-muted"><i class="fe-corner-down-right"></i> <small
                                class="text-uppercase fw-bold">Investigating </small> - <mark>We are
                                currently investigating
                                a latency message and messages send issued for some requests</mark></p>
                        <p class="text-muted"><i class="ps-2"></i><small
                                class="badge bg-soft-success text-secondary mb-3">March, 9 2022
                                8:15am</small></p>

                    </div>
                </div> <!-- end card box-->
            </div><!-- end col-->
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
                            <a href="javascript:void(0);">PLMS-CLZ</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    @endauth

    {{-- <style>
        .container-body {
            height: 800px;
            overflow-y: scroll;
        }

    </style> --}}

@section('script')
    <script src="{{ asset('js/vendor.min.js') }}"></script>
@endsection
@endsection
