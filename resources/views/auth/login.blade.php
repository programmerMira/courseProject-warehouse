@extends('layouts.app')

@section('content')
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 limiter">
                <div class="container-login100">
                    <div class="wrap-login100">
                        <form method="POST" action="/authenticate">
                            @csrf
                            <span class="login100-form-logo">
                                <i class="zmdi zmdi-landscape"></i>
                            </span>
                            <span class="login100-form-title p-b-34 p-t-27">
                                Вход
                            </span>
                            <div class="wrap-input100">
                                <input id="login" type="login" class="input100" name="login" value="{{ old('login') }}" placeholder="Имя пользователя" required autofocus>
                                <span class="focus-input100" data-placeholder="&#xf207;"></span>
                                @isset ($message)
                                    <span class="help-block" style="color:white">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @endisset
                            </div>

                            <div class="wrap-input100">
                                <input id="password" type="password" class="input100 @error('password') is-invalid @enderror" placeholder="Пароль" name="password" required autocomplete="current-password">
                                <span class="focus-input100" data-placeholder="&#xf191;"></span>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="label-checkbox100" for="remember">
                                    {{ __('Запомнить') }}
                                </label>
                            </div>

                            <div class="container-login100-form-btn">
                                <button type="submit" class="login100-form-btn">
                                    {{ __('Вход') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
