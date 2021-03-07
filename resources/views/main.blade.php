<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Приложение - Склад') }}</title>
    <link rel="icon" type="image/png" href="{{asset('../images/icons/favicon.ico')}}"/>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta name="userInfo" content="{{Auth::user()->roles}}">
    <meta name="api-token" content="{{session('token')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://kit.fontawesome.com/4ab76f7642.js" crossorigin="anonymous"></script>
</head>
<body style="background-image: linear-gradient(to bottom, rgba(255,255,255,0.9), rgba(255,255,255,0.9)), url('../images/bg-01.jpg'); background-repeat: repeat-y;">
    <main class="py-4">
        <div id="app">
            <div class="container" style="background-color: white;">
                <!--<ul class="nav justify-content-end">

                    <li class="nav-item dropdown">
                        <a class="nav-link custom-color" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars fa-2x"></i></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item custom-color" href="{{route('history')}}">История изменений</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item custom-color" href="/">Выход</a>
                        </div>
                    </li>
                </ul>-->
                <div>
                    <div class="container-fluid">
                        <!--<ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link custom-color" href="{{route('incomes')}}">Поставки</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-color" href="{{route('deals')}}">Договоры</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-color" href="{{route('details')}}">Детали</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-color" href="{{route('givers')}}">Поставщики</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-color" href="{{route('cards')}}">Учётные карточки</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-color" href="{{route('detail_dict')}}">Словарь деталей</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-color" href="{{route('users')}}">Пользователи</a>
                            </li>
                        </ul>-->
                        <nav class="navbar navbar-expand-md">
                            <a href="/" class="navbar-brand" title="{{Auth::user()->name}}"><i class="fa fa-user-circle fa-3x custom-color"></i></a>
                            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                                <span class="navbar-toggler-icon"><i class="fa fa-bars fa-2x"></i></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarCollapse">
                                <div class="navbar-nav">
                                    @can('readWaybills')
                                        <a class="nav-item nav-link custom-color" href="{{route('incomes')}}">Поставки</a>
                                    @endcan

                                    <a class="nav-item nav-link custom-color" href="{{route('details')}}">Склад</a>

                                    @can('readWaybills')
                                        <a class="nav-item nav-link custom-color" href="{{route('givers')}}">Поставщики</a>
                                    @endcan

                                    @can('readDetailCard')
                                        <a class="nav-item nav-link custom-color" href="{{route('transports')}}">Техника</a>
                                        <a class="nav-item nav-link custom-color" href="{{route('cards')}}">Учётные карточки</a>
                                    @endcan

                                    @can('create')
                                        <a class="nav-item nav-link custom-color" href="{{route('detail_dict')}}">Словарь деталей</a>
                                        <a class="nav-item nav-link custom-color" href="{{route('users')}}">Пользователи</a>
                                    @endcan

                                    <a class="nav-item nav-link custom-color disabled"></a>

                                    <a class="nav-item nav-link custom-color" title="Сформировать файл" data-toggle="modal" data-target="#GenerateModal">
                                        <i class="fas fa-download fa-2x"></i>
                                    </a>
                                    <a class="nav-item nav-link custom-color" title="Загрузить файл" data-toggle="modal" data-target="#UploadModal">
                                        <i class="fas fa-upload fa-2x"></i>
                                    </a>

                                    @can('create')
                                        <a class="nav-item nav-link custom-color" title="История изменений" href="{{route('history')}}">
                                            <i class="fas fa-history fa-2x"></i>
                                        </a>
                                    @endcan

                                    <a class="nav-item nav-link custom-color" title="Выход" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-2x"></i>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                                <div class="navbar-nav ml-auto">

                                </div>
                            </div>
                        </nav>
                        <v-divider></v-divider>
                        <div class="tab-content p-3">
                            @yield('content')
                        </div>
                        @include('excel.upload')
                        @include('excel.generate')
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
