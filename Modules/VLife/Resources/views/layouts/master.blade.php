<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module VLife</title>
        <script src="{{asset('/vendor/autoNumeric/AutoNumeric.js' )}}" type="text/javascript"></script>

       {{-- Laravel Mix - CSS File --}}
       {{-- <link rel="stylesheet" href="{{ mix('css/vlife.css') }}"> --}}

    </head>
    <body>
        @yield('content')

        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/vlife.js') }}"></script> --}}
    </body>
</html>
