@extends('layouts.app')

@section('content')

<div class="container">
    <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
        <h1>Восстановление пароля</h1>

        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <input
                                class="form-control @error('email') is-invalid mb-0 @enderror"
                                id="email"
                                name="email"
                                placeholder="Электронная почта"
                                type="email"
                                autocomplete="email"
                                required autofocus
                                value="{{ old('email') }}"
                            >

                            @error('email')
                            <span class="invalid-feedback mb-3" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 text-center mt-3">
                        <button class="button button-red" type="submit">Восстановить пароль</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
