<?php
/** @var \App\Models\User $user */
/** @var int $contact_id */
?>

<div class="col-md-3">
    <div class="shadow p-3">
        <nav id="accountMenu">
            <ul class="navbar-nav">
                @if ( \Orchid\Access\UserSwitch::isSwitch() )
                <li class="nav-item">
                    <a class="nav-link" href="{{ route( 'logout.switch-user' ) }}">Вернуться в админку</a>
                </li>
                @endif

                @if ( $user->profile->type === \App\Enums\ProfileTypes::SALON )
                <li class="nav-item">
                    <a class="nav-link @yield( 'active-salons-class' )" href="{{ route( 'account.profile.salons.index' ) }}">Салоны</a>
                </li>
                @endif

                <li class="nav-item">
                    @if ( $user->profile->type === \App\Enums\ProfileTypes::SALON )
                    <a class="nav-link" href="#">Профиль салона</a>
                    @else
                    <a class="nav-link" href="#">Профиль</a>
                    @endif

                    <ul class="navbar-nav" style="margin-left: 20px;">
                        <li class="nav-item">
                            <a class="nav-link @yield( 'active-general-class' )" href="{{ route( 'account.profile.general.edit', [ 'contact_id' => $contact_id ] ) }}">Общее</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Галерея</a>

                            <ul class="navbar-nav" style="margin-left: 20px;">
                                <li class="nav-item">
                                    <a
                                        class="nav-link @yield( 'active-work-gallery-tattoo-class' )"
                                        href="{{ route( 'account.profile.work-gallery.index', [ 'type' => \App\Enums\SpecializationTypeNames::TATTOO, 'contact_id' => $contact_id ] ) }}">Тату</a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link @yield( 'active-work-gallery-piercing-class' )"
                                        href="{{ route( 'account.profile.work-gallery.index', [ 'type' => \App\Enums\SpecializationTypeNames::PIERCING, 'contact_id' => $contact_id ] ) }}">Пирсинг</a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link @yield( 'active-work-gallery-tatuaje-class' )"
                                        href="{{ route( 'account.profile.work-gallery.index', [ 'type' => \App\Enums\SpecializationTypeNames::TATUAJE, 'contact_id' => $contact_id ] ) }}">Татуаж</a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link @yield( 'active-work-gallery-other-class' )"
                                        href="{{ route( 'account.profile.work-gallery.index', [ 'type' => \App\Enums\SpecializationTypeNames::OTHER, 'contact_id' => $contact_id ] ) }}">Другое</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield( 'active-services-class' )" href="{{ route( 'account.profile.services.edit', [ 'contact_id' => $contact_id ] ) }}">Услуги</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield( 'active-additional-services-class' )" href="{{ route( 'account.profile.additional-services.edit', [ 'contact_id' => $contact_id ] ) }}">Доп. услуги</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield( 'active-video-gallery-class' )" href="{{ route( 'account.profile.video-gallery.edit', [ 'contact_id' => $contact_id ] ) }}">Галерея видео</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield( 'active-contact-class' )" href="{{ route( 'account.profile.contact.edit', [ 'contact_id' => $contact_id ] ) }}">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield( 'active-social-networks-class' )" href="{{ route( 'account.profile.social-networks.edit', [ 'contact_id' => $contact_id ] ) }}">Соц. сети</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield( 'active-working-hours-class' )" href="{{ route( 'account.profile.working-hours.edit', [ 'contact_id' => $contact_id ] ) }}">Часы работы</a>
                        </li>
                    </ul>
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
