<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')

            <div class="loader">
            </div>
        </main>

        <div id="confirm_modal_area"></div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script>

        $(document).ready(function () {
            $(document).on('click', '.deleteModalButton', function () {
                var id = $(this).data('id');
                var delete_url = $(this).data('delete-url');
                var model = $(this).data('model');
                var field_name = $(this).data('field-name');

                $.ajax({
                    type: 'post',
                    data:{ id, delete_url, model, field_name},
                    url: '{{ route('confirm_delete_modal') }}',
                    success:function(data){
                        $('#confirm_modal_area').html(data);
                    },
                    error:function(data){
                        $('#confirm_modal_area').html('<div class="alert alert-danger alert-dismissable"><i class="fal fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> <b>Save Failed</b> <div id="saveajaxerrordiv"></div> </div>');
                        var result = jQuery.parseJSON(data.responseText);
                        if (result) {
                            var errors = result.errors;
                            //loop over error object, and get to it's
                            for (var key in errors ) {
                                // skip loop if the property is from prototype
                                if (!errors .hasOwnProperty(key)) continue;
                                var obj = errors [key];
                                for (var prop in obj) {
                                    // skip loop if the property is from prototype
                                    if(!obj.hasOwnProperty(prop)) continue;
                                    $('#saveajaxerrordiv').append('<li>'+obj[prop]+'</li>'); //update the error div
                                }
                            }
                        }
                    },
                });//end ajax
            });
        });

    </script>

    @yield('customjavascript')
</body>
</html>
