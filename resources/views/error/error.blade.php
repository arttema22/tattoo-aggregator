@extends( 'layouts.app' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Ошибка {{ $code ?? 404 }}</h1>
                    <p>Страницы не существует или произошла какая-то ошибка.</p>
                    <a class="button button-red mt-4" href="{{ route( 'index' ) }}">на главную</a>
                </div>
            </div>
        </div>
    </div>

@endsection
