<?php
/** @var string $type */
/** @var array $dictionaries */
/** @var \App\Models\Contact $salon */
?>

@extends('layouts.app')

@section( 'active-work-gallery-' . $type . '-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Добавить в &laquo;<span style="text-transform: lowercase;">{{ \App\Helpers\SpecialisationTypeHelper::titleFromName( $type ) }}</span>&raquo;</h1>

                    <form
                        id="gallery"
                        name="gallery"
                        method="POST"
                        action="{{ route( 'account.profile.work-gallery.store', [ 'contact_id' => $contact_id, 'type' => $type ] ) }}"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        <div class="row mt-3">
                            <div class="col-md-5">
                                <div id="upload-container">
                                    <div>
                                        <input id="file-image" name="work" type="file" required>
                                        <label for="file-image" style="position: absolute; top: 0; left: 0;">Загрузить файл</label>
                                        <img class="img-fluid w-100 visually-hidden" src="" alt="Работа">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="name" placeholder="Название работы" required>

                                @foreach( ($dictionaries[ $type ] ?? []) as $k => $item )
                                    <div class="col-md-12 filter-form filter-select mb-3">
                                        <select class="select-gallery" name="attribute[{{ $item['id'] }}]" id="{{ $k }}">
                                            <option value="0">{{ $item[ 'title' ] }}</option>

                                            @foreach( $item[ 'data' ] as $i => $val )
                                                <option value="{{ $i }}">{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach

                                <textarea name="description" id="description" placeholder="Описание" rows="4" class="form-control"></textarea>
                            </div>

                            <div class="col-md-12">
                                <button class="button button-red mt-4 w-100" type="submit">Добавить</button>
                            </div>
                        </div>

                    </form>

                </div>

                @include( 'account.menu-2' )
            </div>
        </div>
    </div>

    <script type="application/javascript">
        (()=>{
            const wrap = document.querySelector( '#upload-container' );
            const file = wrap.querySelector( 'input[type="file"]' );
            const img  = wrap.querySelector( 'img' );

            file.addEventListener( 'change', function ( e ) {
                const current = e.target.files;
                if ( current.length > 0 ) {
                    img.src = URL.createObjectURL( current[ 0 ] );
                    wrap.style.backgroundColor = 'inherit';
                    wrap.style.height = 'auto';
                    img.classList.remove( 'visually-hidden' );
                }
            }, false );
        })();
    </script>

@endsection
