<?php
/** @var \Illuminate\Database\Eloquent\Collection $additional_service_name */
/** @var \App\Models\Contact $salon */
/** @var int $contact_id */
?>

@extends('layouts.app')

@section( 'active-additional-services-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Дополнительные услуги</h1>

                    <div class="mt-5 additionally">
                        <form
                            method="POST"
                            action="{{ route( 'account.profile.additional-services.update', [ 'contact_id' => $contact_id ] ) }}"
                        >
                            @csrf

                            @foreach( $additional_service_name as $item )
                            @php
                                $as = $salon->additionalServices->where( 'as_id', '=', $item->id )?->first() ?? null;
                            @endphp

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    id="additionalServices[{{ $item->id }}]"
                                    name="additionalServices[{{ $item->id }}][as_id]"
                                    type="checkbox"
                                    value="{{ $item->id }}"
                                    @if( $as ) checked @endif
                                >
                                <input type="hidden" name="additionalServices[{{ $item->id }}][id]" value="{{ $as?->id ?? 0 }}">
                                <label class="form-check-label" for="additionalServices[{{ $item->id }}]">{{ $item->name }}</label>
                            </div>
                            @endforeach

                            <button class="button button-red mt-4" type="submit">Сохранить</button>
                        </form>
                    </div>
                </div>

                @include( 'account.menu-2' )
            </div>
        </div>
    </div>

@endsection
