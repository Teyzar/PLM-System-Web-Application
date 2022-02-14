@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/units.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('body')
    <div style="margin-left: 8%; margin-right: 9%;" class="">
        <div class="container-fluid pt-2 col-md-6">

            <form id="search-form" method="POST" class="">
                @csrf
                <div class="has-search input-group mt-4">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control rounded has-search d-flex" placeholder="Search" name="search"
                        id="search">
                    <div class="btn-group col-md-3">
                        <select class="form-select dropdown-toggle" type="button" name="select">
                            <option value="id">Id</option>
                            <option value="phone_number">Phone number</option>
                            <option value="active">Status</option>
                            <option value="updated_at">Registration Update</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">search</button>
                </div>
            </form>
        </div>
        <div class="float-end">
            <a href="" class="btn register" data-bs-toggle="modal" data-bs-target="#store-unit" data-toggle="tooltip"
                title="Register">
                <span class="fs-6 text-dark opacity-100">Register</span>
            </a>
        </div>
    </div>
    <div style="margin-left: 8%; margin-right: 8%;">

        <div class="container-fluid mt-5">

            <div class="row">
                <div class="table-responsive-sm">
                    @if (count($units) <= 0)
                        <div class="card border-1 border-secondary align-items-center pt-5 ">
                            <span class="justify-content-center d-flex pb-5 pt-2 text-danger opacity-75 addicon fs-5">
                                Empty Units
                            </span>
                        </div>
                    @else
                        <table class="table table-md text-start inner-menu shadow">
                            <div class="">
                                <tr class="client--nav-tabs text-secondary">
                                    <th width="5%">Id</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Mobile #</th>
                                    <th width="20%">Longitude</th>
                                    <th width="20%">Latitude</th>
                                    <th width="25%">Registration&nbsp;Update</th>
                                </tr>
                            </div>

                            <tbody class="searchbody bg-light border-0 " id="tb">
                                @foreach ($units as $unit)
                                    <tr class="trbody bg-light client--nav tdhover">
                                        <td class="text-danger">
                                            {{ $unit->id }}
                                        </td>
                                        <td class="">
                                            {{ $unit->active }}
                                        </td>
                                        <td class="">
                                            {{ $unit->phone_number }}
                                        </td>

                                        <td class="">
                                            {{ $unit->longitude }}
                                        </td>

                                        <td class="">
                                            {{ $unit->latitude }}
                                        </td>

                                        <td class="">
                                            {{ \Carbon\Carbon::parse($unit->updated_at)->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- pagination --}}
                        <div class="d-flex justify-content-center fs-10">
                            {{ $units->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#search-form').submit(function(event) {
                    event.preventDefault();
                    var $form = $(this);

                    var value = $form.find("input[name='search']").val();
                    var selectValue = $form.find("select[name='select']").val();


                    console.log(value);
                    $.ajax({
                        type: 'get',
                        url: `units-search`,
                        data: {
                            'searchTerm': value,
                            'selectTerm': selectValue
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('.searchbody').html(data.result);
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                });
            });
        </script>

        @include('modals.units')

    @endsection
