@extends('layouts.master')
@section('title', 'Noneco Cadiz City')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" charset="utf-8"></script>
    
</head>

<body>
    <div>
        <h1>
            Live Map
            {{-- @foreach ($admin as $accs)
            {{$accs->id}}
            {{$accs->username}}
            {{$accs->password}}
            @endforeach --}}
        </h1>
    </div>

</body>
</html>
@endsection
