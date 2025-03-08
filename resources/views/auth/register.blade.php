@extends('layouts.app')

@section('content')

<div class="container">
    <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
        <div class="row">
            <div class="col-md-12">
                <h1>Регистрация</h1>
                <div class="form-registration">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button aria-controls="pills-home" aria-selected="true" class="nav-link active" data-bs-target="#pills-home" data-bs-toggle="pill" id="pills-home-tab" role="tab" type="button">Салон</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button aria-controls="pills-profile" aria-selected="false" class="nav-link" data-bs-target="#pills-profile" data-bs-toggle="pill" id="pills-profile-tab" role="tab" type="button">Мастер</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div aria-labelledby="pills-home-tab" class="tab-pane fade show active" id="pills-home" role="tabpanel">
                            <form method="POST" action="{{ route('register') }}" class="mt-5">
                                @csrf

                                <input type="hidden" name="type" value="{{ \App\Enums\ProfileTypes::SALON }}">

                                <div class="row">
                                    <div class="col-md-12">
                                        <input class="form-control @error('name') is-invalid mb-0 @enderror" name="name" placeholder="Название" type="text" value="{{ old('name') }}" required>

                                        @error('name')
                                        <span class="invalid-feedback mb-3" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control @error('email') is-invalid mb-0 @enderror" name="email" placeholder="Электронная почта" type="email" value="{{ old('email') }}" required>

                                        @error('email')
                                        <span class="invalid-feedback mb-3" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control @error('password') is-invalid mb-0 @enderror" name="password" placeholder="Пароль" type="password" required>

                                        @error('password')
                                        <span class="invalid-feedback mb-3" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <button class="button button-red" type="submit">Зарегистрироваться</button>
                                </div>
                            </form>
                        </div>
                        <div aria-labelledby="pills-profile-tab" class="tab-pane fade" id="pills-profile" role="tabpanel">
                            <form method="POST" action="{{ route('register') }}" class="mt-5">
                                @csrf

                                <input type="hidden" name="type" value="{{ \App\Enums\ProfileTypes::MASTER }}">

                                <div class="row">
                                    <div class="col-md-12">
                                        <input class="form-control @error('name') is-invalid mb-0 @enderror" name="name" placeholder="Имя" type="text" value="{{ old('name') }}" required>

                                        @error('name')
                                        <span class="invalid-feedback mb-3" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control @error('email') is-invalid mb-0 @enderror" name="email" placeholder="Электронная почта" type="email" value="{{ old('email') }}" required>

                                        @error('email')
                                        <span class="invalid-feedback mb-3" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control @error('password') is-invalid mb-0 @enderror" name="password" placeholder="Пароль" type="password" required>

                                        @error('password')
                                        <span class="invalid-feedback mb-3" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <button class="button button-red" type="submit">Зарегистрироваться</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="application/javascript">
    (()=>{
        window.addEventListener( 'load', () => {
            if ( location.hash === '#master' ) {
                ( new bootstrap.Tab( document.querySelector('#pills-tab button[data-bs-target="#pills-profile"]') ) ).show();
            }
        } );
    })();
</script>

@endsection
