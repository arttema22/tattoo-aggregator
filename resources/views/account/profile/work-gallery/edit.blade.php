<?php
/** @var string $type */
/** @var \App\Models\Contact $salon */
?>

@extends('layouts.app')

@section( 'active-work-gallery-' . $type . '-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Изменить информацию о работе</h1>

                    @if ( session()->has( 'success' ) )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="box-sizing: inherit;"></button>
                        </div>
                    @endif

                    <form
                        id="gallery"
                        name="gallery"
                        method="POST"
                        action="{{ route( 'account.profile.work-gallery.update', [ 'contact_id' => $contact_id, 'type' => $type, 'id' => $file['id'] ] ) }}"
                    >

                        @csrf

                        <div class="row mt-3">
                            <div class="col-md-5">
                                <img class="img-fluid w-100" id="salon-cover" src="{{ Storage::url( 'images/original/' . ( $file->original ?? '' ) ) }}" alt="">
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="name" placeholder="Название работы" value="{{ $file->fileInfo?->name ?? '' }}">

                                @foreach( ($dictionaries[ $type ] ?? []) as $k => $item )
                                    <div class="col-md-12 filter-form filter-select mb-3">
                                        <select class="select-gallery" name="attribute[{{ $item[ 'id' ] }}]" id="{{ $k }}">
                                            <option value="0">{{ $item[ 'title' ] }}</option>

                                            @foreach( $item[ 'data' ] as $i => $val )
                                                <option
                                                    value="{{ $i }}"
                                                    @if( ( $attributes[ 'd' . $item[ 'id' ] ][0] ?? 0 ) === $i ) selected @endif
                                                >
                                                    {{ $val->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach

                                <textarea
                                    name="description"
                                    id="description"
                                    placeholder="Описание"
                                    rows="4"
                                    class="form-control"
                                >{{ $file->fileInfo?->description ?? '' }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <button class="button button-red mt-4 w-100" type="submit">Сохранить</button>
                            </div>
                        </div>

                    </form>
                </div>

                @include( 'account.menu-2' )
            </div>
        </div>
    </div>

@endsection
