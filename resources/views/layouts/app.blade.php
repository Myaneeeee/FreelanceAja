<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>FreelanceAja - @yield('title')</title>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">  <!-- ✅ Full-height flex container -->

  @include('partials.navbar')

  <main class="flex-fill py-4">
    <div class="container">
      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      @yield('content')
    </div>
  </main>

  @section('footer')
    @include('partials.footer')
  @show

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
