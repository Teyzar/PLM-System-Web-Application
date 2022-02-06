@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/home.js') }}" defer></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('body')
    <div class="container mt-5 ">
        <div class="card align-items-center w-auto flex-row justify-content-between p-2 fs-5 px-3">
            Units
            <a href="" class="btn bg-danger text-light a:hover bg-dark" data-bs-toggle="modal" data-bs-target="#modalForm">
                Register Unit
            </a>
        </div>
    </div>
    <div class="container">
        <div class="card-header">
            <div class="row">
                <table class ="table-bordered">
                    <tr class =>
                        <th>
                            phone_number
                        </th>
                        <th>
                            longitude
                        </th>
                        <th>
                            latitude
                        </th>
                    </tr>
                        @foreach ($units as $unit)
                            <tr>
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

                </table>
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
                    <form action="{{ route('add_unit') }}" method="POST">
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
    <style>
        .modal-open .container-fluid,
        .modal-open .container {
            -webkit-filter: blur(5px) grayscale(90%);
        }

    </style>
@endsection
