<?php
/** @var \App\Models\Contact $salon */
?>

<div class="salon-menu-wrapper">
    <div class="container">
        <ul class="nav nav-tabs" id="salon-menu" role="tablist">
            <!--<li class="nav-item">
                <a class="nav-link">Записаться онлайн</a>
            </li>
            <li class="nav-item">
                <a class="nav-link">Скачать эскизы</a>
            </li>-->

            <li class="nav-item">
                <a class="nav-link  active" id="mtab-3" data-bs-toggle="tab" data-bs-target="#description">Описание</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="mtab-4" data-bs-toggle="tab" data-bs-target="#services">Услуги</a>
            </li>

            @if ( $albums->where( 'type', '=', \App\Enums\SpecializationTypes::TATTOO )->first()->files->isNotEmpty() )
            <li class="nav-item">
                <a class="nav-link" id="mtab-5" data-bs-toggle="tab" data-bs-target="#tattoo-gallery">Тату</a>
            </li>
            @endif

            @if ( $albums->where( 'type', '=', \App\Enums\SpecializationTypes::PIERCING )->first()->files->isNotEmpty() )
            <li class="nav-item">
                <a class="nav-link" id="mtab-6" data-bs-toggle="tab" data-bs-target="#piercing-gallery">Пирсинга</a>
            </li>
            @endif

            @if ( $albums->where( 'type', '=', \App\Enums\SpecializationTypes::TATUAJE )->first()->files->isNotEmpty() )
            <li class="nav-item">
                <a class="nav-link" id="mtab-7" data-bs-toggle="tab" data-bs-target="#tatuaje-gallery">Татуажа</a>
            </li>
            @endif

            @if ( $videos->isNotEmpty() )
            <li class="nav-item">
                <a class="nav-link" id="mtab-9" data-bs-toggle="tab" data-bs-target="#video-gallery">Видео</a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" id="mtab-11" data-bs-toggle="tab" data-bs-target="#contact">Контакты</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="mtab-12" data-bs-toggle="tab" data-bs-target="#review">Отзывы</a>
            </li>
        </ul>
    </div>
</div>
