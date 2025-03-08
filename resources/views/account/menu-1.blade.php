<div class="col-md-3">
    <div class="shadow p-3">
        <nav id="accountMenu">
            <ul class="navbar-nav">
                @if ( \Orchid\Access\UserSwitch::isSwitch() )
                <li class="nav-item">
                    <a class="nav-link" href="{{ route( 'logout.switch-user' ) }}">Вернуться в админку</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link @yield( 'active-salons-class' )" href="{{ route( 'account.profile.salons.index' ) }}">Салоны</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @yield( 'active-setting-class' )" href="{{ route( 'account.profile.settings.edit' ) }}">Настройки</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route( 'logout' ) }}">Выход</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
