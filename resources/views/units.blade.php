@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/units.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('content')
    <div style="margin-left: 8%; margin-right: 9%;" class="">
        <div class="container-fluid col-7 pt-2">
            <form id="search-form" method="POST" class="">
                @csrf
                <div class="has-search input-group mt-4 col-md-2">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control rounded d-flex" placeholder="Search" name="search" id="search">
                    <div class="btn-group col-md-2">
                        <select class="form-select dropdown-toggle" type="button" name="select">
                            <option value="">Select</option>
                            <option value="id">Id</option>
                            <option value="active">Status</option>
                            <option value="phone_number">Phone&nbsp;number</option>
                            <option value="updated_at">Updated&nbsp;Last</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-primary invisible">search</button>
                </div>
            </form>
        </div>
        <div class="float-end">
            <a href="" class="btn register" data-bs-toggle="modal" data-bs-target="#store-unit" data-toggle="tooltip"
                title="Register">
                <i class="fa-solid fa-plus pe-2"></i><span class="fs-6 text-dark opacity-100">Register</span>
            </a>
        </div>
    </div>
    <div style="margin-left: 8%; margin-right: 8%;">
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="table-responsive-sm">
                    @if (count($units) <= 0)
                        <table id="table" class="table table-md text-start">
                            <thead class="">
                                <tr class="client--nav-tabs text-secondary">
                                    <th width="5%">Id</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Mobile #</th>
                                    <th width="20%">Longitude</th>
                                    <th width="20%">Latitude</th>
                                    <th width="20%">Updated&nbsp;Last</th>
                                    <th width="5%">&nbsp;</th>
                                </tr>
                            </thead>
                        </table>
                    @else
                        <table id="table" class="table table-md text-start">
                            <thead class="">
                                <tr class="client--nav-tabs text-secondary">
                                    <th width="5%">Id</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Mobile #</th>
                                    <th width="20%">Longitude</th>
                                    <th width="20%">Latitude</th>
                                    <th width="20%">Updated&nbsp;Last</th>
                                    <th width="5%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="client--nav-tabs text-secondary">
                                    <th width="5%">Id</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Mobile #</th>
                                    <th width="20%">Longitude</th>
                                    <th width="20%">Latitude</th>
                                    <th width="20%">Updated&nbsp;Last</th>
                                    <th width="5%">&nbsp;</th>
                                </tr>
                            </tfoot>
                            <tbody class="searchbody bg-light border-0 " id="tb">
                                @foreach ($units as $unit)
                                    <tr id="{{ $unit->id }}" class="trbody bg-light client--nav tdhover data">
                                        <td class="text-danger">
                                            {{ $unit->id }}
                                        </td>
                                        <td class="">
                                            {{ $unit->active ? 'Normal' : 'Fault' }}
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
                                            {{ $unit->updated_at }}
                                        </td>
                                        <td class="">
                                            <button id="delbtn" class="btn border-0 deletebtn float-end"
                                                onclick="removeUnit({{ $unit->id }})" type="button">
                                                <i class="fas fa-trash fs-5 text-danger bs-tooltip-top tooltip-arrow"
                                                    data-toggle="tooltip" data-bs-placement="top" title="Remove"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center fs-10">
                            {{ $units->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (count($errors) > 0)
            <script>
                $(document).ready(function() {
                    $('#store-unit').modal('show');
                });
            </script>
        @endif

        @include('modals.units')

        <script>
            $(document).ready(function() {
                $('#table').DataTable({
                    "lengthMenu": [
                        [10, 20, 50, -1],
                        [10, 20, 50, "All"]
                    ],
                    "bFilter": false,
                    'columnDefs': [{
                        'targets': [6],
                        'orderable': false, // orderable false
                    }],
                });

                $('[data-toggle="tooltip"]').tooltip();
                $('#search-form').submit(function(event) {
                    event.preventDefault();
                    var $form = $(this);
                    var value = $form.find("input[name='search']").val();
                    var selectValue = $form.find("select[name='select']").val();

                    $.ajax({
                        type: 'get',
                        url: 'units-search',
                        data: {
                            'searchTerm': value,
                            'selectTerm': selectValue
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('.searchbody').html(data.result);
                        },
                        error: (error) => console.log(error)
                    });
                });
            });

            function removeUnit(id) {
                $('#modalRemove').modal('show');
                console.log('here');

                $('#remove-id').submit(function(event) {
                    event.preventDefault();
                    $.ajax({
                        type: 'delete',
                        url: `units/${id}`,
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(data) {
                            $(`#${id}`).fadeOut('slow');
                            location.reload();
                        },
                        error: (error) => console.log(error)
                    });
                })
            }

            var submitbtn = $('#submitbtn');
            var spinner = $('#spinner');
            var phone_num = $('#phone_number');
            var time = $('#timer');
            var closebtn = $('#close');
            var bar = $('#bar');
            var processing = $('#processing');

            bar.hide();

            submitbtn.on('click', function() {
                if (phone_num.val() !== "") {
                    submitbtn.hide();
                    closebtn.hide();
                    bar.fadeIn();
                    // function TimeOut() {
                    //     setTimeout(() => {
                    //         processing.html('Processing');
                    //         setTimeout(() => {
                    //             processing.html('Processing.');
                    //             setTimeout(() => {
                    //                 processing.html('Processing..');
                    //                 setTimeout(() => {
                    //                     processing.html('Processing...');
                    //                     TimeOut();
                    //                 }, 1000);
                    //             }, 1000);
                    //         }, 1000);
                    //     }, 1000)
                    // }

                    // TimeOut();

                    // var width = 0;
                    // var progress = document.getElementById('progress');
                    // var sec = 0;
                    // setTimeout(ProgressBar, 1000);

                    // function ProgressBar() {
                    //     width++;
                    //     sec++;

                    //     if (sec < 31) {
                    //         setTimeout(ProgressBar, 1000);
                    //     }
                    //     var percent = $('#percent');

                    //     progress.style.width = width * 3 + "%";

                    //     if (progress.style.width == '18%') {
                    //         width += 2;
                    //     } else if (progress.style.width == '45%') {
                    //         width += 2;
                    //     } else if (progress.style.width == '102%') {
                    //         progress.style.width = '100%'
                    //     } else if (progress.style.width == '105%') {
                    //         progress.style.width = '100%'
                    //     }
                    //     percent.html(progress.style.width);
                    // }
                } else {
                    console.log('empty')
                }
            });
        </script>
    @endsection
