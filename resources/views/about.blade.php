@extends('layouts.app')

@section('head')
    {{-- <link rel="stylesheet" href="{{ mix('css/icons.min.css') }}" type="text/css" /> --}}
@endsection


@section('content')
    <div class="container-fluid" style="padding-top: 10%">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <i class="mdi mdi-comment-question-outline fs-1"></i>
                    <h1 class="mb-3 text-warning">What is Power Line Monitoring System ?</h3>
                        <p class="fs-4"> <span class="fw-bolder">Power Line Monitoring System </span>is a
                            system
                            developed by University of St. La Salle, Computer Engineering students
                            <br /><b>John Samuel Chavez, Juruel Keanu Lorenzo, and Thomas Andrew Zaragoza.</b><br /> The
                            sole
                            purpose of the
                            development is to provide a system for Northern Negros Electric Cooperative (Cadiz City) which
                            allows<br /> them to detect power outages in the city and provide automated dispatching of
                            linemen to the
                            field.
                        </p>
                        <hr class="container">
                        <div class="mt-4 col-12">
                            <p class="h4 text-success"><b>Contact Us</b></p>
                            <p class="waves-effect waves-light me-1"><i class="mdi mdi-phone-message me-1"></i>
                                +639773163348</p>
                            <p class="waves-effect waves-light me-1"><i
                                    class="mdi mdi-email-outline me-1"></i>clzplms@gmail.com</p>
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection
