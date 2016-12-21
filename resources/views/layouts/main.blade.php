<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    </head>
    <body>
        @yield('main_content')

        <script type="text/javascript" src="{{ asset('js/all.js') }}"></script>
    </body>
</html>
