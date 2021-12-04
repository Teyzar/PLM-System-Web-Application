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
    <div class="center">
        <h1 class = "text">Login</h1>
        <form method="POST" action = "{{url('/main/checklogin')}}">
            {{csrf_field()}}
            <div class="inputfield">
                <input type="text" required="" name = "user">
                <span></span>
                <label>Username</label>
            </div>
            <div class="inputfield">
                <input type="password" required="" name = "pass">
                <span></span>
                <label>Password</label>
            </div>
            <button type = "submit" name = "loginbtn">Login</button>
        </form>
    </div>
</body>
</html>
@endsection
