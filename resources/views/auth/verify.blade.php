@extends('layouts.app')

@section('content')

<div class="container">
    <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
        <h1>Подтвердите свою электронную почту</h1>

        <div class="row">
            <div class="col-md-12">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.
                    </div>
                @endif

                Прежде чем продолжить, пожалуйста, проверьте свою электронную почту на наличие ссылки для подтверждения.
                <br>
                Если вы не получили электронное письмо,
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">нажмите здесь, для повторной отправки</button>.
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
