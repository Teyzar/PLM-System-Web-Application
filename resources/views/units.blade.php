@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/units.css') }}" rel="stylesheet">
@endsection

@section('body')
    <div style="margin-left: 8%; margin-right: 9%;">
        <div class="container-fluid">
            <div class="container-fluid p-2">
                <div class="clients-form-group has-search col-md-10">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" placeholder="Search" id="adminClientSearchInput" name="search">
                </div>
            </div>
        </div>
        <a href="" class="btn float-end register" data-bs-toggle="modal" data-bs-target="#store-unit" data-toggle="tooltip"
            title="Register">
            <span class="fs-6 text-dark opacity-100">Register number</span>
        </a>
    </div>

    <div style="margin-left: 8%; margin-right: 8%;">
        <div class="container-fluid m-auto mt-5">
            <div class="row">
                <div class="table-responsive-sm table-responsive-md">
                    @if (count($units) <= 0)
                        <div class="card border-1 border-secondary align-items-center pt-5 ">
                            <span class="justify-content-center d-flex pb-5 pt-2 text-danger opacity-75 addicon fs-5">
                                Empty Units
                            </span>
                        </div>
                    @else
                        <table class="table inner-menu shadow">
                            <div class="">
                                <tr class="fs-6 client--nav-tabs text-dark">
                                    <th width="25%">Mobile #</th>
                                    <th width="25%">Longitude</th>
                                    <th width="20%">Latitude</th>
                                    <th width="20%">Date</th>
                                </tr>
                            </div>

                            <tbody class="searchbody bg-light border-0 " id="tb">
                                @foreach ($units as $unit)
                                    <tr class="trbody bg-light client--nav tdhover">
                                        <td class="fs-6 text-black text-capitalize">
                                            {{ $unit->phone_number }}
                                        </td>

                                        <td class="text-black fs-6">
                                            {{ $unit->longitude }}
                                        </td>

                                        <td class="text-black fs-6 text-capitalize">
                                            {{ $unit->latitude }}
                                        </td>

                                        <td class="text-black fs-6 text-capitalize">
                                            {{ \Carbon\Carbon::parse($unit->updated_at)->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- pagination --}}
                        {{-- <div class="d-flex justify-content-center fs-10">
                    {{ $unit->links() }}
                </div> --}}
                    @endif
                </div>
            </div>
        </div>
        @include('modals.units')
    @endsection
