<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'berco') }}</title>

    <!-- Scripts -->
    @vite('resources/js/app.js')

    <!--
    <script src="{{ asset('js/app.js') }}" defer></script>
    -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <!-- Styles -->

    <!--
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    -->
</head>
<body>
    <div id="app">

    </div>
</body>
</html>
