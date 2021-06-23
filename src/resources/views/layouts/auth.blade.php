<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel-2FA') }}</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 75px;
            padding-bottom: 75px;
            background-color: #f5f5f5;
        }

        .auth-form {
            width: 100%;
            min-width: 450px;
            padding: 25px;
            margin: auto;
        }
    </style>

    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="d-flex h-100 text-center">
    <div class="cover-container d-flex mx-auto flex-column ">
        @yield('content')
    </div>
</body>

</html>