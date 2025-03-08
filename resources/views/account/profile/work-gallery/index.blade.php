<?php
/** @var int $contact_id */
/** @var string $type */
/** @var \App\Models\Contact $salon */
/** @var \App\Models\Album $album */
?>

@extends('layouts.app')

@section( 'active-work-gallery-' . $type . '-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-9">
                            <h1>{{ \App\Helpers\SpecialisationTypeHelper::titleFromName( $type ) }}</h1>
                        </div>
                        <div class="col-3 text-end">
                            <a
                                href="{{ route( 'account.profile.work-gallery.create', [ 'contact_id' => $contact_id, 'type' => $type ] ) }}"
                                title="Добавить работу"
                                class="button button-red"
                            ><i class="fa-solid fa-plus"></i>&nbsp;Добавить</a>
                        </div>
                    </div>

                    @if ( session()->has( 'success-remove' ) )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('success-remove') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="box-sizing: inherit;"></button>
                        </div>
                    @endif

                    <div class="row galery-wrapper mt-3">
                        @foreach( ($album?->files ?? []) as $item )
                            @if ( ( $item[ 'thumbs' ][ 's' ][ 'path' ] ?? null ) !== null )
                            <div class="col-md-3">
                                <div class="galery-item">
                                    <span class="gallery-item-btn gallery-item-edit">
                                        <a
                                            href="{{ route( 'account.profile.work-gallery.edit', [ 'contact_id' => $contact_id, 'type' => $type, 'id' => $item->id ] ) }}"
                                            title="Редактировать информация о работе"
                                        >
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                    </span>
                                    <span class="gallery-item-btn gallery-item-del">
                                        <a
                                            href="{{ route( 'account.profile.work-gallery.delete', [ 'contact_id' => $contact_id, 'type' => $type, 'id' => $item->id ] ) }}"
                                            title="Удалить работу"
                                        >
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </span>
                                    <div class="gallery-item-info-wrap">
                                        @if ( $item->fileInfo->is_approved === \App\Enums\WorkApproved::WAIT )
                                            <span class="gallery-item-info" style="line-height: 1.9em;" title="Работа на модерации, пока не показывается на сайте.">
                                                <i class="fa-regular fa-clock text-info" style="margin-left: 5px;"></i>
                                            </span>
                                        @elseif ( $item->fileInfo->is_approved === \App\Enums\WorkApproved::APPROVE )
                                            <span class="gallery-item-info" style="line-height: 2em;" title="Работа отклонена и не показывается на сайте. Свои вопросы можно направить администрации сайта.">
                                                <i class="fa-solid fa-check text-success" style="margin-left: 5px;"></i>
                                            </span>
                                        @elseif ( $item->fileInfo->is_approved === \App\Enums\WorkApproved::REJECT )
                                            <span class="gallery-item-info" style="line-height: 2em;" title="Работа одобрена и показывается на сайте.">
                                                <i class="fa-solid fa-ban text-danger" style="margin-left: 5px;"></i>
                                            </span>
                                        @endif

                                        @if ( $item->fileInfo->is_adult === 1 )
                                            <span class="gallery-item-info" style="line-height: 1.8em;" title="Работа отмечена как 18+">
                                                <i class="fa-solid fa-triangle-exclamation text-warning" style="margin-left: 4px;"></i>
                                            </span>
                                        @endif
                                    </div>

                                    <img alt="" src="{{ Storage::url( $item[ 'thumbs' ][ 's' ][ 'path' ] ) }}">
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                @include( 'account.menu-2' )
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
@endpush
