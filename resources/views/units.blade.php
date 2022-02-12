@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/units.css') }}" rel="stylesheet">
@endsection

@section('body')
    <div class="container-fluid mt-5 ">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="clients-search" style="margin-left: 7%; margin-right: 7%;">
                    <form action="" method="get" id="adminClientSearch">
                        <div class="clients-form-group has-search">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="Search" id="adminClientSearchInput"
                                name="search">
                        </div>
                    </form>
                </div>
                <div class="clients--filter-container">&nbsp;
                </div>
                <div class="inner-menu shadow col-md-10 table-responsive" style="margin-left: 7%; margin-right: 7%;">
                    <div class="client--nav-container">
                        <ul class="nav client--nav-tabs">
                            <p class="clients--name-heading mb-0 col-md-3">
                                <a class="btn-link d-inline-flex border-0 p-2 text-dark fs-6 " href="">
                                    Phone Number
                                </a>
                            </p>
                            <p style="margin-left: -35px;margin-right: 63px;" class="clients--portal-heading col-md-2 mb-0">
                                <a class="btn-link d-inline-flex border-0 p-2 text-dark fs-6"
                                    onclick="" href="">
                                    Longitude
                                </a>
                            </p>
                            <p style="margin-left: -66px; margin-right: 65px;" class="clients--account-heading col-md-2 mb-0 ">
                                <a class="btn-link d-inline-flex border-0 p-2 text-dark fs-6"
                                    onclick="" href="">
                                    Latitude
                                </a>
                            </p>
                            <p style="margin-left: -49px;margin-right: 40px;"
                                class="clients--companyname-heading col-md-2 mb-0">
                                <a class="btn-link d-inline-flex border-0 p-2 text-dark fs-6"
                                    onclick="" href="">
                                    updated_at
                                </a>
                            </p>
                        </ul>
                    </div>
                    <div id="clients-user-list" class="client--tab"></div>
                </div>
            </div>
        </div>
        @foreach ($units as $unit)
                <ul class="nav client--nav col-md-10" style="margin-left: 7%; margin-right: 7%;">
                    <p style="max-width: 20%; !important" class="clients--name col-3 mb-0 p-2 text-dark">
                        {{ $unit->phone_number }} </p>
                    <p class="clients--portal-heading col-md-2 mb-0 p-2 text-dark ps-5"> {{$unit->longitude}} </p>
                    <p class="clients--account col-md-2 mb-0 p-2 text-dark ps-5"> {{$unit->latitude}} </p>
                    <p class="clients--companyname col-md-2 mb-0 border-0 p-2 text-dark w-0 ps-5">
                        {{ \Carbon\Carbon::parse($unit->updated_at)->toDayDateTimeString() }} </p>
                </ul>
        @endforeach
    </div>
@endsection
