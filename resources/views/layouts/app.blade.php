
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php $time = Carbon\Carbon::now()->timestamp; ?>
    <link href='{{ asset("css/app.css?v=$time") }}' rel="stylesheet" type="text/css">
   
    <script src='{{ asset("js/app.js?v=$time") }}' defer></script>
    
    <script src="{{ asset('js/jquery-ui.js') }}" defer></script>
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('js/notify.min.js') }}" defer></script>
    
    <title>{{config("app.name")}}</title>

    <link rel="apple-touch-icon" sizes="57x57" href="{{Storage :: url ('favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('storage/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('storage/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('storage/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('storage/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('storage/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('storage/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('storage/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('storage/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="144x144" href="{{ asset('storage/favicon/android-icon-144x144.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('storage/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('storage/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#2c7a7b">
    <meta name="msapplication-TileImage" content="{{ asset('storage/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#2c7a7b">

</head>
<body>
    <div id="app" class="flex flex-col mx-auto overflow-hidden h-full max-w-md bg-gray-100 text-gray-800 border-l border-r relative">

        @if (Auth::check()) @include('partials.topnav') @endif
        @if (Auth::check()) @include('partials.sidenav') @endif

        <main class="flex-1 overflow-auto pb-10 z-0">
            @if(Session::has('message'))
                <div class="flex justify-between items-center absolute top-0 right-0 m-4 mt-12 bordred bg-green-400 rounded-lg text-sm px-4 py-1 alert">
                    <div class="text-green-100 mr-4">{{ Session::get('message') }}</div>
                    <div class="text-gray-100 font-bold hover:text-gray-300 cursor-pointer alert-close" data-target="alert"><i class="fas fa-times"></i></div>
                </div> 
            @endif
            @if (Auth::check())
                <h1 class="font-sans font-bold subpixel-antialiased text-base m-2 mt-3 mb-3 text-gray-700">
                    @yield('title')
                </h1>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>