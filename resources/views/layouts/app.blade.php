<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_csrf" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/54cca6735a.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="text-white bg-info pt-2">
        <section class="pageHeader">
            <div class="container mx-auto col-12 col-xl-6 col-md-8">
                <h1>Twitter-like</h1>
            </div>
        </section>

        <ul class="container mx-auto navbar col-12 col-xl-6 col-md-8 mb-0">
            <li><a href="/">Home</a></li>
            @if (Auth::guest())
            <li><a href="/explore">Explore</a></li>
            <li><a href="/login">Login</a></li>
            @else
            <li><a href="/feed">Feed</a></li>
            <li><a href="/user/{{ Auth::user()->username }}">Posts</a></li>
            <li><a href="/explore">Explore</a></li>
            <li><a href="/logout">Logout</a></li>
            @endif
        </ul>
    </div>
    <section id="titleSection" class="pageTitle mx-auto col-12 py-4 bg-light border-bottom">
        <div class="container mx-auto col-12 col-xl-6 col-md-8 d-flex flex-row justify-content-between align-items-center">
            <h2 class="mb-0 py-0">@yield('title')</h2>
            @if (isset($following))
            <div class="p-3 position-relative">
                @if (isset($following->id))
                <button id="{{ $user->id }}" type="button" class="btn btn-dark follow @if(Auth::guest())guest @endif">Following</button>
                @else
                <button id="{{ $user->id }}" type="button" class="btn btn-outline-dark follow @if(Auth::guest())guest @endif">Follow</button>
                @endif
                <span class="position-absolute bottom-0 right-0 translate-middle badge rounded-pill bg-danger">
                    {{ $user->followed->count() }}
                </span>
            </div>
            @endif
        </div>
    </section>

    <section class="content mx-auto col-12 col-xl-6">
        <div class="container mx-auto">
            @yield('content')
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>