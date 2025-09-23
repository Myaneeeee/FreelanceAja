<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FreelanceAja - @yield('title')</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    @section('navbar')
        @include('layouts.navbar')
    @show

    <div class="container min-vh-100">
        @yield('content')
    </div>

    @section('footer')
        @include('layouts.footer')
    @show
</body>

</html>
