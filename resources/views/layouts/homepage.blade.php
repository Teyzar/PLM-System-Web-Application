<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/homepage.css" rel="stylesheet">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" charset="utf-8"></script>
</head>
<body>
    <header>
        <div class = "nav">
            <ul class = "headers"> 
                <li class = "list"><a href="/">Home</a></li>
                <li class = "list"><a href="">Past Incidents</a></li>
                <li class = "list"><a href="" id = "acc">Accounts</a></li>
                <li class = "list"><a href="" id = "unit">Units</a></li>
                <li class = "login"><a href="/login">Login</a></li>
            </ul>
        </div>
    </header>
    @yield('content')


</body>
</html>