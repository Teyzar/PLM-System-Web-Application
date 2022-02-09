@extends('layouts.app')

@section('head')
    <script src="{{ mix('js/home.js') }}" defer></script>
    <link href="{{ mix('css/home.css') }}" rel="stylesheet">
@endsection

@section('body')
    <div id="map" style="height: 891px"></div>
@endsection
