<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'لوحة التحكم' }}</title>
    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/normalize.css') }}" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap.rtl.min.css') }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/all.min.css') }}" />
    <!-- Main File Css  -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/main.css') }}" />
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="shortcut icon" type="image/jpg" href="{{ display_file(setting('fav')) }}" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite('resources/js/app.js')
    @yield('css')
    @livewireStyles
</head>

<body>
    <!-- Start layout -->
    @include('dashboard.layouts.navbar')
    <div class="app">
        @include('dashboard.layouts.sidebar')
        @yield('contant')
        {{ $slot ?? '' }}
    </div>
    <!-- End layout -->
    <!-- Js Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('dashboard/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/all.min.js') }}"></script>
    <script data-navigate-once src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('dashboard/js/main.js') }}"></script>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        // var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        //     cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
        // });
        // PUSHER_APP_ID = 2064298
        // PUSHER_APP_KEY = 2 f781955a5e3c4f265c4
        // PUSHER_APP_SECRET = e72864a77111725fd7cb
        // PUSHER_HOST =
        //     PUSHER_PORT = 443
        // PUSHER_SCHEME = "https"
        // PUSHER_APP_CLUSTER = "mt1"



        var pusher = new Pusher("2f781955a5e3c4f265c4", {
            cluster: "mt1"
        });


        var channel = pusher.subscribe('chat-message');
        channel.bind('message-sent', function(data) {
            Livewire.dispatch('refreshChat');
            //Update Icon
            fetch("{{ route('dashboard.unread-count') }}")
                .then(res => res.json())
                .then(data => {
                    const el = document.getElementById('count-converstion-icon');
                    if (el) {
                        el.textContent = data.count;
                    }
                });
        });
    </script>
    @stack('scripts')
    @livewireScripts
</body>

</html>
