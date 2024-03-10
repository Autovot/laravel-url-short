<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="build/assets/app-UpvIgzcU.css">
    <title>@yield('titulo')</title>
</head>

<body>
    @section('header')

        <a href="/">
            <h1>Laravel URL Shortener</h1>
        </a>

    @show
    @yield('main')
</body>

</html>
