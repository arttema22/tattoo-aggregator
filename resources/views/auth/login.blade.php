@extends('layouts.app')

@section('content')

<div class="container">
    <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
        <h1>Войти в личный кабинет</h1>

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <input class="form-control @error('email') is-invalid mb-0 @enderror" id="email" name="email" placeholder="Электронная почта" type="email" autocomplete="email" required autofocus value="{{ old( 'email' ) }}">

                            @error('email')
                            <span class="invalid-feedback mb-3" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <input class="form-control @error('password') is-invalid mb-0 @enderror" id="password" name="password" placeholder="Пароль" type="password" autocomplete="current-password" required>

                            @error('password')
                            <span class="invalid-feedback mb-3" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{--<div class="col-md-12">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                class="form-check-input"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="remember">{{ __('Запомнить меня') }}</label>
                        </div>--}}
                    </div>

                    <div class="col-md-12 text-center mt-3">
                        <button class="button button-red" type="submit">Войти</button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Забыли пароль?') }}
                            </a>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
