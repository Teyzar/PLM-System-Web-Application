@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{mix('css/records.css')}}">
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row w-100 text-muted">
            {{-- @for ($i = 0; $i < 1; $i++) --}}
            <div class="col-md-4 p-2 record-card">
                <div class="card-header shadow-card">
                    <span class="h6">March 4, 2022</span>
                </div>
                <div class="card-body bg-white shadow-card">
                    <p>Longitude: 10.363333</p>
                    <p>Latitude: 10.553322</p>
                    <p>Location: Cadiz</p>
                    <p>Time: 5:56pm</p>
                    <p>Unit no. 5</p>
                </div>
            </div>
            <div class="col-md-4 p-2 record-card">
                <div class="card-header shadow-card">
                    <span class="h6">March 5, 2022</span>
                </div>
                <div class="card-body bg-white shadow-card">
                    <p>Longitude: 10.22111</p>
                    <p>Latitude: 11.33322</p>
                    <p>Location: Brngy. Daga</p>
                    <p>Time: 4:46pm</p>
                    <p>Unit no. 8</p>
                </div>
            </div>
            <div class="col-md-4 p-2 record-card">
                <div class="card-header shadow-card">
                    <span class="h6">March 6, 2022</span>
                </div>
                <div class="card-body bg-white shadow-card">
                    <p>Longitude: 09.111222</p>
                    <p>Latitude: 07.2333221</p>
                    <p>Location: Brngy. Singcang</p>
                    <p>Time: 3:23am</p>
                    <p>Unit no. 9</p>
                </div>
            </div>
            <div class="col-md-4 p-2 record-card">
                <div class="card-header shadow-card">
                    <span class="h6">March 7, 2022</span>
                </div>
                <div class="card-body bg-white shadow-card">
                    <p>Longitude: 12.3321111</p>
                    <p>Latitude: 13.44422111</p>
                    <p>Location: Brngy. Lupit</p>
                    <p>Time: 7:58pm</p>
                    <p>Unit no. 10</p>
                </div>
            </div>
            {{-- @endfor --}}
        </div>
    </div>
@endsection
