@extends('layouts.app')

@section( 'active-salons-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Добавить новый салон</h1>

                    <div class="mt-5">
                        <form
                            method="POST"
                            action="{{ route( 'account.profile.salons.store' ) }}"
                        >
                        @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <input class="form-control" name="name" placeholder="Название салона" type="text" value="">
                                </div>
                            </div>

                            <button class="button button-red mt-4" type="submit">Сохранить</button>
                        </form>
                    </div>
                </div>

                @include( 'account.menu-1' )
            </div>
        </div>
    </div>

@endsection
