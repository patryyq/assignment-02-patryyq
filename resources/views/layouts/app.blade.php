<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/54cca6735a.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <section class="pageHeader">
        <div class="container mx-auto">
            <h1>Twitter-like</h1>
        </div>
    </section>

    <ul class="container mx-auto navbar">
        <li><a href="/">Home</a></li>
        @if (Auth::guest())
        <li><a href="/login">Login</a></li>
        @else
        <li><a href="/logout">Logout</a></li>
        @endif
    </ul>


    <section class="pageTitle">
        <div class="container mx-auto">
            <h2>@yield('title')</h2>
        </div>
    </section>

    <section class="content">
        <div class="container mx-auto">
            @yield('content')
        </div>
    </section>
</body>

</html>