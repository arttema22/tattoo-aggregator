<?php
/** @var \App\Models\Contact $salon */
?>

@extends('layouts.app')

@section( 'active-video-gallery-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Видео галерея</h1>

                    <p>Можно указывать полную ссылку на один из видео хостингов:</p>
                    <ul>
                        <li>YouTube</li>
                        <li>RuTube</li>
                    </ul>

                    <div class="mt-5 items-video">
                        <form
                            method="POST"
                            action="{{ route( 'account.profile.video-gallery.add', [ 'contact_id' => $contact_id ] ) }}"
                            name="video"
                        >
                            @csrf

                            <div class="item-video d-flex position-relative">
                                <span class="wraper-info position-absolute">
                                    <img class="info" data-bs-content="Загрузите видео для презентации вашего салона" data-bs-original-title="" data-bs-placement="bottom" data-bs-toggle="popover" src="{{ asset( '/images/icons/info.svg' ) }}" title="">
                                </span>
                                <input class="form-control" name="url" id="video-url" placeholder="Добавьте URL-ссылку" type="url" required>
                                <button class="add-plus" type="button">+</button>
                            </div>
                        </form>
                    </div>

                    <table class="table table-striped table-hover">
                        <tbody>
                        @foreach( $salon->videos as $item )
                            <tr>
                                <td class="align-middle">
                                    <img src="{{ $item->preview ?? '/images/video/wait.jpg' }}" alt="video" style="max-width: 100px;">
                                </td>
                                <td class="align-middle">{{ $item->url }}</td>
                                <td class="text-end align-middle">
                                    <a
                                        class="btn btn-danger"
                                        href="{{ route( 'account.profile.video-gallery.remove', [ 'contact_id' => $contact_id, 'video' => $item->id ] ) }}"
                                        title="Удалить салон салоне"
                                    >
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @include( 'account.menu-2' )
            </div>
        </div>
    </div>

    <script type="application/javascript">
        (()=>{
            const allow_host = [
                'youtube.com',
                'youtu.be',
                'rutube.ru'
            ];
            const btn  = document.querySelector( '.add-plus' );
            const url  = document.querySelector( '#video-url' );
            const form = document.forms[ 'video' ];

            btn.addEventListener( 'click', function () {
                let [ ,,host ] = url.value.split( '/' );
                host = host.replace( 'www.', '' );

                if ( !allow_host.includes( host ) ) {
                    alert( 'Ошибка: видео не из разрешенных видеохостингов' );
                    url.value = '';
                    return;
                }

                form.submit();
            }, false );
        })();
    </script>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
@endpush
