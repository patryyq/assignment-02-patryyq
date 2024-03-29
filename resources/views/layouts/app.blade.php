<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_csrf" content="{{ csrf_token() }}">
    <title>Twitter-like</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/54cca6735a.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="text-white bg-info pt-2">
        <section class="pageHeader">
            <div
                class="container mx-auto col-xl-7 col-md-12 col-xs-12 d-flex flex-row justify-content-between align-items-center position-relative">
                <a href="/" class="link-light">
                    <h1>Twitter-like</h1>
                </a>
                @if (!Auth::guest())
                    <a href="/messages"><i class="far fa-comment-alt" aria-hidden="true" style="color:white">
                            <span id="msgCount"
                                class="position-absolute bottom-0 right-0 translate-middle badge rounded-pill bg-danger">
                                {{ App\Models\Message::where('read', 0)->where('to_user_id', Auth::id())->get()->count() }}
                            </span></i></a>

                @endif
            </div>
        </section>
        <ul class="container mx-auto navbar col-xl-7 col-md-12 col-xs-12 mb-0">
            @if (Auth::guest())
                <li><a href="/">Home</a></li>
                <li><a href="/explore">Explore</a></li>
                <li><a href="/login">Login</a></li>
            @else
                <li><a href="/feed">Feed</a></li>
                <li><a href="/user/{{ Auth::user()->username }}">My Posts</a></li>
                <li><a href="/explore">Explore</a></li>
                <li><a href="/logout">Logout</a></li>
            @endif
        </ul>
    </div>
    <section id="titleSection" class="pageTitle mx-auto col-12 pb-2 pt-3 bg-light border-bottom">
        <div class="container mx-auto col-xl-7 col-md-10">
            <div class="row d-flex flex-direction-column g-0">
                <div class="col-12 col-md-8 p-2">
                    @yield('title')
                </div>
                <div class="col-8 mx-auto col-md-4">
                    @if (isset($following))
                        <div class="p-3 position-relative d-flex flex-wrap"
                            style="flex-direction: column;align-content: stretch;">
                            @if ($user->id != Auth::id())
                                <button name="send_dm" id="{{ $title }}" type="button"
                                    class="m-2 btn btn-outline-dark follow @if (Auth::guest())guest @endif">Send DM
                                </button>
                            @endif

                            @if (isset($following->id))
                                <button id="{{ $user->id }}" type="button"
                                    class="m-2 btn btn-dark follow @if (Auth::guest())guest @endif">Following</button>
                            @else
                                <button id="{{ $user->id }}" type="button"
                                    class="m-2 btn btn-outline-dark follow @if (Auth::guest())guest @endif">Follow</button>
                            @endif
                            <span class="position-absolute bottom-0 translate-middle badge rounded-pill bg-danger"
                                style="right:0">
                                {{ $user->followed->count() }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="content mx-auto col-xl-7 col-md-12">
        <div class="container mx-auto">
            @yield('content')
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        Echo.private('App.Models.User.{{ Auth::id() }}')
            .notification((notification) => {
                let data = [notification.status, notification.data];
                displayNotification(data)
                return data;
            });

        //     // Example 1 - Event Channel
        //     Echo.channel('events')
        //         .listen('RealTimeMessage', (e) => console.log('RealTimeMessage: ' + e.message));

        //   //  Example 2 - Private Event Channel
        //     Echo.private('events')
        //         .listen('RealTimeMessage', (e) => console.log('Private RealTimeMessage: ' + e.message));
    </script>
    <script src="/js/notificationsMessages.js"></script>
</body>

</html>
