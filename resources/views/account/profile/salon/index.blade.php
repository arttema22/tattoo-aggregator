<?php
/** @var \Illuminate\Database\Eloquent\Collection $salons */
?>

@extends('layouts.app')

@section( 'active-salons-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-9">
                            <h1>Салоны</h1>
                        </div>
                        <div class="col-3 text-end">
                            <a
                                href="{{ route( 'account.profile.salons.create' ) }}"
                                title="Добавить салон"
                                class="button button-red"
                            ><i class="fa-solid fa-plus"></i>&nbsp;Добавить</a>
                        </div>
                    </div>

                    <div class="mt-5">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Название</th>
                                    <th scope="col">Адрес</th>
                                    <th style="min-width: 100px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $salons as $item )
                                    <tr>
                                        <th class="align-middle" scope="row">{{ $item->name }}</th>
                                        @php
                                            $address = $item->city->name[ 'ru' ] ?? '';
                                            if ( $address !== '' ) {
                                                $address .= ', ';
                                            }
                                            $address .= $item->address;
                                        @endphp
                                        <td class="align-middle">
                                            @if ( $address )
                                                {{ $address }}
                                            @else
                                                <i class="text-secondary">адрес не указан</i>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a
                                                class="btn btn-danger"
                                                href="{{ route( 'account.profile.general.edit', [ 'contact_id' => $item->id ] ) }}"
                                                title="Редактировать информацию о салоне"
                                            >
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>

                                            <a
                                                class="btn btn-danger"
                                                href="{{ route( 'account.profile.salons.delete', [ 'contact_id' => $item->id ] ) }}"
                                                title="Удалить салон"
                                            >
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @include( 'account.menu-1' )
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
@endpush
