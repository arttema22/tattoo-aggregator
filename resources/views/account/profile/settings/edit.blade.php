<?php
/** @var \App\Models\User $user */
?>

@extends('layouts.app')

@section( 'active-setting-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Настройки аккаунта</h1>

                    <div class="mt-5">
                        <form
                            id="settings"
                            name="settings"
                            method="POST"
                            action="{{ route( 'account.profile.settings.update' ) }}"
                        >
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <input class="form-control" name="current_password" placeholder="Текущий пароль" type="password">
                                </div>
                                <div class="col-md-12">
                                    <input class="form-control" name="password" placeholder="Новый пароль" type="password">
                                </div>
                                <div class="col-md-12">
                                    <input class="form-control" name="password_confirm" placeholder="Подтверждение нового пароля" type="password">
                                </div>
                            </div>

                            <button class="button button-red mt-3" type="submit">Сохранить</button>
                        </form>
                    </div>
                </div>

                @if ( $user->profile->type === \App\Enums\ProfileTypes::SALON )
                    @include( 'account.menu-1' )
                @else
                    @include( 'account.menu-2' )
                @endif
            </div>
        </div>
    </div>

@endsection
