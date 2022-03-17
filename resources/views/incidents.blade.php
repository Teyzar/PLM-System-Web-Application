@extends('layouts.app')

@section('head')
    {{-- <link rel="stylesheet" href="{{ mix('css/incidents.css') }}"> --}}
@endsection

@section('content')
    <div class="container-fluid pt-3 mb-5">
        <div class="row">

            {{-- {{ dd($incidents->info()) }} --}}
            @foreach ($incidents as $incident)
                <div class="col-lg-12">
                    <div class="card project-box">
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
                                        <a class="dropdown-item text-danger" href="#"><i
                                                class="fe-delete pe-1"></i><span>Remove</span></a>
                                    </div>
                                </div> <!-- end dropdown -->
                            @endauth
                            <h5 class="mt-0"><span
                                    class="text-dark fs-4">{{ \Carbon\Carbon::parse($incident->created_at)->toDayDateTimeString() }}</span>
                            </h5>
                            <hr>
                            @foreach ($incident->info()->get() as $info)
                                <span class="text-uppercase fw-bolder h5 mt-0">{{ $info->title }}</span> <i
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
                            <a href="javascript:void(0);">PLMS-CLZ</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    @endauth
@endsection

@section('script')
    <script src="{{ asset('js/vendor.min.js') }}"></script>
@endsection
