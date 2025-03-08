<?php
/** @var \Illuminate\Database\Eloquent\Collection $social_network_name */
/** @var \App\Models\Contact $salon */
/** @var int $contact_id */
?>

@extends('layouts.app')

@section( 'active-social-networks-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Социальные сети</h1>

                    <div class="mt-5 social-networks">
                        <form
                            id="social_networks"
                            name="social_networks"
                            method="POST"
                            action="{{ route( 'account.profile.social-networks.update', [ 'contact_id' => $contact_id ] ) }}"
                        >
                            @csrf

                            @foreach( $social_network_name as $item )
                                @php
                                    $sn = $salon->socialNetworks->where( 'sn_id', '=', $item->id )?->first() ?? null;
                                @endphp

                                <div class="col-md-12">
                                    <input
                                        class="form-control"
                                        name="socialNetworks[{{ $item->id }}][value]"
                                        placeholder="{{ $item->name }}"
                                        type="text"
                                        value="{{ $sn?->value ?? '' }}"
                                    >
                                    <input type="hidden" name="socialNetworks[{{ $item->id }}][id]" value="{{ $sn?->id ?? 0 }}">
                                    <input type="hidden" name="socialNetworks[{{ $item->id }}][sn_id]" value="{{ $item->id }}">
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
