<?php
/** @var \Illuminate\Database\Eloquent\Collection $additional_service_name */
/** @var \App\Models\Contact $salon */
/** @var int $contact_id */

?>

@extends('layouts.app')

@section( 'active-working-hours-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Часы работы</h1>
                    <p>Пусть люди знают, когда Вы открыты.</p>

                    <div class="mt-5 working-hours">
                        <form
                            id="working_hours"
                            name="working_hours"
                            method="POST"
                            action="{{ route( 'account.profile.working-hours.update', [ 'contact_id' => $contact_id ] ) }}"
                        >
                            @csrf

                            <table>
                                <thead>
                                    <tr>
                                        <th scope="col">День</th>
                                        <th scope="col">Открыто с</th>
                                        <th scope="col">Открыто до</th>
                                        <th scope="col">Выходной</th>
                                        <th scope="col">Круглосуточно</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach( $salon->workingHours as $item )
                                    <tr>
                                        <td>{{ \App\Helpers\WeekdayHelper::convertToString( $item->day ) }}</td>
                                        <td>
                                            <input name="workingHours[{{ $item->id }}][id]" type="hidden" value="{{ $item->id }}">
                                            <input name="workingHours[{{ $item->id }}][day]" type="hidden" value="{{ $item->day }}">
                                            <input class="form-time" name="workingHours[{{ $item->id }}][start]" type="text" value="{{ $item->start }}">
                                        </td>
                                        <td>
                                            <input class="form-time" name="workingHours[{{ $item->id }}][end]" type="text" value="{{ $item->end }}">
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" name="workingHours[{{ $item->id }}][is_weekend]" type="checkbox" value="1" @if( $item->is_weekend ) checked @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" name="workingHours[{{ $item->id }}][is_nonstop]" type="checkbox" value="1" @if( $item->is_nonstop ) checked @endif>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            <button class="button button-red mt-4" type="submit">Сохранить</button>
                        </form>
                    </div>
                </div>

                @include( 'account.menu-2' )
            </div>
        </div>
    </div>

@endsection
