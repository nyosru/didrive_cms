@extends('didrive.app.app')

@section('css')

    @if ( ( date('H') + 5 ) > 7 && ( date('H') + 5 ) < 11)
        {{--  --}}
        <style>
            body {
                background-image: url('/img/bg-enter.jpg');
            }

        </style>
    @elseif( ( date('H') + 5 ) >= 18 && ( date('H') + 5 ) <= 7 ) <style> body { background-image:
            url('/img/bg-enter-night.jpg'); } </style>
        @else <style>
                body {
                    background-image: url('/img/bg-enter-day.jpg');
                }

            </style>
    @endif

    <style>
        html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {


            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            font-family: Arial, Tahoma, Helvetica, sans-serif;
        }

        .inin {
            position: absolute;
            top: 35%;
            right: 25%;
            padding: 15px 30px;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .inindown {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 15px;
            text-align: center;
        }

        .inindown span {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 5px;
            padding: 5px 10px;
            line-height: 30px;
        }

        .m_alert {
            background-color: yellow;
            border-radius: 5px;
            margin-top: 10px;
            padding: 10px;
            max-width: 200px;
        }

    </style>
@endsection


@section('content')

    <div class="inin">
        @include('auth.social')

        @if (session('noaccess_msg'))
            <div class="m_alert">
                Авторизация пройдена успешно
                <br />
                <br />
                {{ session('noaccess_msg') }}
            </div>
        @endif

    </div>

    <div class="inindown">
        <span>
            <a href="https://php-cat.com" target="_blank">Программирование и&nbsp;юзабилити
                хороших&nbsp;интерфейсов&nbsp;php-cat.com</a>
        </span>
    </div>

    @if (1 == 2)
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Login') }}</div>

                        <div class="card-body">
                            @include('auth.social')
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
