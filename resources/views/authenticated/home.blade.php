@extends('layouts.home')

@section('head')
    <script src="{{ asset('js/home.js') }}" defer></script>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
        <div id="map" class="h-100 w-100"></div>
@endsection
