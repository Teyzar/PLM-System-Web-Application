@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/units.css') }}" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-light border"
                style="height: 20%;">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                    <a href="/units" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-dark text-decoration-none ">
                        <span class="fs-5 d-none d-sm-inline"><i class="fs-4 fa-solid fa-house pe-2"></i>{{ __('Power Outage Units') }}</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li>
                            <a href="#submenu1" data-bs-toggle="collapse" class="btn nav-link px-0 align-middle text-dark dropdown-toggle">
                                <i class="fs-4 fa-solid fa-sim-card"></i> <span class="ms-1 d-none d-sm-inline ">Units</span>
                            </a>
                            <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                <li>
                                    <a href="{{URL::to('add_units')}}" class="nav-link px-0 text-muted"> <span class="d-none d-sm-inline ps-2">&nbsp;&nbsp;Add units</span><i class="fs-6 ps-2 fw-bold">&#8594;</i></a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0 text-muted"> <span class="d-none d-sm-inline ps-2">&nbsp;&nbsp;Show units</span><i class="fs-6 ps-2 fw-bold">&#8594;</i></a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#" class="nav-link px-0 align-middle text-dark">
                                <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Dispatch</span> </a>
                        </li>

                    </ul>

                </div>
            </div>
            <div class="col py-3 bg-white">
                {{-- Content area... --}}

                @yield('content-body')
            </div>
        </div>
    </div>
    <div class="modal fade pt-5" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-4 text-center" id="exampleModalLabel">Register unit</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ URL::to('units') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="phone_number"><i class="fs-2 bi bi-sim px-1"></i>Mobile No.</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                placeholder="#" />
                        </div>

                        <div class="modal-footer d-block">
                            <button type="submit" class="btn btn-warning float-end">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
