<?php
/** @var \App\Models\Contact $salon */
?>

@extends('layouts.app')

@section( 'active-general-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Общая информация</h1>

                    @if ( session()->has( 'success' ) )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="box-sizing: inherit;"></button>
                        </div>
                    @endif

                    <div class="mt-5">
                        <form
                            method="POST"
                            action="{{ route( 'account.profile.general.update', [ 'contact_id' => $contact_id ] ) }}"
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <div class="row">
                                <div class="input-group col-md-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3" style="padding: 0.88em; border-radius: 0;">{{ route( 'salon.index', [ '' ] ) . '/' }}</span>
                                    </div>
                                    <input class="form-control @error( 'alias' ) is-invalid @enderror" name="alias" placeholder="Адрес на сайте" type="text" value="{{ $salon->alias }}">
                                    @error( 'alias' )
                                        <span class="invalid-feedback" role="alert" style="margin-top: -1em; margin-bottom: 1em;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <input class="form-control @error( 'name' ) is-invalid @enderror" name="name" placeholder="Имя" type="text" value="{{ $salon->name }}">
                                    @error( 'name' )
                                        <span class="invalid-feedback" role="alert" style="margin-top: -1em; margin-bottom: 1em;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-sm-12">
                                    <textarea class="form-control" id="description" name="description" placeholder="Описание" rows="4">{{ $salon->description }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="envelope-wrapper">
                                        <span class="wraper-info position-absolute">
                                            <img class="info" src="{{ asset( '/images/icons/info.svg' ) }}" data-bs-placement="bottom" data-bs-toggle="popover" data-bs-content="Загрузите фото для презентации вашего салона" data-bs-original-title="" title="" alt="">
                                        </span>
                                        <input name="cover" type="file" id="envelope-file" class="field envelope-file">
                                        <label class="envelope-file-wrapper" for="envelope-file">
                                            <span class="envelope-file-fake">Фото обложки</span>
                                            <span class="envelope-file-button">Загрузить файл</span>
                                        </label>
                                    </div>
                                    <div class="envelope-wrapper-img mt3 mb-20 position-relative">
                                        <img class="img-fluid" id="salon-cover" src="{{ Storage::url( $salon->cover[ 'thumbs' ][ 'b' ][ 'path' ] ?? ('images/original/' . ($salon->cover[ 'original' ] ?? '')) ) }}" alt="">
                                    </div>
                                </div>
                            </div>

                            <button class="button button-red mt-4" type="submit">Отправить</button>
                        </form>
                    </div>
                </div>

                @include( 'account.menu-2' )
            </div>
        </div>
    </div>

    <script type="application/javascript">
        (()=>{
            const file = document.querySelector( '#envelope-file' );
            const img  = document.querySelector( '#salon-cover' );

            file.addEventListener( 'change', function ( e ) {
                const current = e.target.files;
                if ( current.length > 0 ) {
                    img.src = URL.createObjectURL( current[ 0 ] );
                }
            }, false );
        })();
    </script>

@endsection
