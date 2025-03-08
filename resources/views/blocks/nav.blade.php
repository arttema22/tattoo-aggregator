<div class="menu-wrapper">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{ route( 'index' ) }}">
                <img src="{{ asset( '/images/logo.svg' ) }}" alt="Логотип ТатуГуру" width="80px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link active" href="{{ route( 'search.tattoo' ) }}">Тату</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route( 'search.piercing' ) }}">Пирсинг</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route( 'search.tatuaje' ) }}">Татуаж</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-4" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Салоны по городам
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown-4">
                            @foreach( ( $catalog_by_city ?? [] ) as $item )
                                <li>
                                    <a class="dropdown-item" href="{{ route( 'catalog.city', [ 'city' => $item[ 'alias' ] ] ) }}">
                                        {{ $item[ 'name' ] }}
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <a class="dropdown-item" href="{{ route( 'catalog.index' ) }}"><strong>Другие города</strong></a>
                            </li>
                        </ul>
                    </li>

                    @if ( auth()->guest() )
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Владельцам студий
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown-1">
                            <li>
                                <a class="dropdown-item" href="{{ route( 'register' ) }}#salon">Регистрация</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route( 'account.profile.index' ) }}">Личный кабинет</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Мастерам
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown-2">
                            <li>
                                <a class="dropdown-item" href="{{ route( 'register' ) }}#master">Регистрация</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route( 'account.profile.index' ) }}">Личный кабинет</a>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route( 'account.profile.index' ) }}">Личный кабинет</a>
                    </li>
                    @endif

                    <li class="nav-item dropdown">
                        {{--<a class="nav-link" href="{{ route( 'article.all' ) }}">Блог</a>--}}
                        <a class="nav-link dropdown-toggle" href="{{ route( 'article.all' ) }}" id="navbarDropdown-5" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Блог
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown-5">
                            @foreach( ( $categories_for_article ?? [] ) as $item )
                                <li>
                                    <a class="dropdown-item" href="{{ route( 'article.category.all', [ 'alias' => $item[ 'alias' ] ] ) }}">
                                        {{ $item[ 'name' ] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link active" href="">Вакансии</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-6" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Обучение
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown-6">
                        </ul>
                    </li>-->
                    {{--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown-7" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Информация
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown-7">
                        </ul>
                    </li>--}}
                </ul>
            </div>
        </nav>
    </div>
</div>
