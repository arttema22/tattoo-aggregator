<?php
use App\Enums\ProfileTypes;
?>

@extends( 'layouts.app' )

@section( 'active-services-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Профиль</h1>

                    @if ( $user->profile->type === ProfileTypes::SALON )
                        <p>Добро пожаловать в личный кабинет владельца салонов.</p>
                        <p>Здесь вы можете можете заполнить информацию о вашем салоне, чтобы клиенты могли легко найти:</p>
                    @else
                        <p>Добро пожаловать в личный кабинет владельца мастера по тату.</p>
                        <p>Здесь вы можете можете заполнить информацию о себе, чтобы клиенты могли легко найти:</p>
                    @endif

                    <ul>
                        <li>где вы находитесь;</li>
                        <li>какие услуги предлагаете;</li>
                        @if ( $user->profile->type === ProfileTypes::SALON )
                            <li>какие есть отличительные черты вашего салона;</li>
                        @endif
                        <li>время работы;</li>
                        <li>на каких альтернативных площадках можно с вами связаться.</li>
                    </ul>
                    <p>Также вы можете выкладывать ваши работы, которые будут выводиться в поиске на сайте. Если клиенту понравится ваша работа, он легко сможет с вами связаться.</p>
                    <p>Портал активно разрабатывается, тут будут появляться новые возможности для вашего удобства и повышения прибыльности бизнеса.</p>
                </div>

                @if ( $user->profile->type === ProfileTypes::SALON )
                    @include( 'account.menu-1' )
                @else
                    @include( 'account.menu-2' )
                @endif
            </div>
        </div>
    </div>

@endsection
