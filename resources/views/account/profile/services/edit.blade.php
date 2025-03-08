<?php
/** @var \App\Models\Contact $salon */
/** @var array $services */
/** @var array $service_default */
?>

@extends('layouts.app')

@section( 'active-services-class', 'active' )

@section( 'content' )

    <div class="container">
        <div class="simple-page-wrapper pt-5 mb-5" style="min-height: calc(100vh - 380px);">
            <div class="row">
                <div class="col-md-9">
                    <h1>Услуги</h1>

                    <div class="mt-5 add-servis">
                        <form
                            method="POST"
                            action="{{ route( 'account.profile.services.update', [ 'contact_id' => $contact_id ] ) }}"
                        >
                            @csrf

                            @foreach( \App\Enums\SpecializationTypeNames::labels() as $k => $v )
                                @php
                                    $empty = isset( $services[$k] ) && $services[$k]->isNotEmpty();
                                    $hide  = !isset( $services[$k] ) || ($services[$k]->first()?->status ?? 1) === 0;
                                @endphp

                                <div class="form-check">
                                    <div @if ( $empty && !$hide ) class="open-checkbox" @endif>
                                        <input class="form-check-input service-type" id="{{ $k }}" type="checkbox" value="" @if ( $empty && !$hide ) checked @endif>
                                        <label class="form-check-label" for="{{ $k }}">{{ $v }}</label>

                                        <div class="service-help-btns">
                                            <button class="btn btn-link btn-sm service-clear" @if( !$empty ) disabled @endif title="Очистить список">
                                                Очистить
                                            </button>
                                            <button class="btn btn-link btn-sm service-fill" @if( $empty ) disabled @endif
                                                    title="Заполнить услугами из значений по умолчанию" data-type="{{ $k }}" data-typeId="{{ \App\Enums\SpecializationTypeNames::toId( $k ) }}">Автозаполнение
                                            </button>
                                        </div>
                                    </div>
                                    <div class="checkbox-block">
                                        <table class="table table-sm table-services">
                                            <thead>
                                            <tr>
                                                <th>Название</th>
                                                <th>От</th>
                                                <th>Цена</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if ( $empty )
                                                @foreach( $services[$k] as $item )
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="services[{{ $item->id }}][id]"
                                                                   value="{{ $item->id }}">
                                                            <input type="hidden" name="services[{{ $item->id }}][type]"
                                                                   value="{{ $item->type }}">
                                                            <input class="service-status" type="hidden"
                                                                   name="services[{{ $item->id }}][status]"
                                                                   value="{{ $item->status }}">
                                                            <input class="form-control service-name" type="text"
                                                                   name="services[{{ $item->id }}][name]"
                                                                   value="{{ $item->name }}">
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       name="services[{{ $item->id }}][is_start_price]"
                                                                       @if( $item->is_start_price ) checked
                                                                       @endif value="1">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="hidden"
                                                                   name="services[{{ $item->id }}][currency]"
                                                                   value="{{ $item->currency }}">
                                                            <input class="form-control" type="text"
                                                                   name="services[{{ $item->id }}][price]"
                                                                   value="{{ $item->price }}" style="width: 100px;">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger service-remove">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td>
                                                    <input class="form-control" type="text"
                                                           placeholder="Название услуги">
                                                    <span class="invalid-feedback" role="alert"></span>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" value="0"
                                                           style="width: 100px;">
                                                    <span class="invalid-feedback" role="alert"></span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger"
                                                            data-type="{{ \App\Enums\SpecializationTypeNames::toId( $k ) }}">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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

    <script type="application/javascript">
        (() => {
            let new_index = 1;
            const default_services = {
                @foreach( $service_default as $k => $items )
                "{{ $k }}": {!! json_encode( $items->pluck('name')->toArray() ) !!},
                @endforeach
            };

            const removeBtn = function( e ) {
                let tr = e.target.parentNode.parentNode;
                if ( e.target.tagName === 'I' ) {
                    tr = tr.parentNode;
                }
                let body = tr.parentNode;
                body.removeChild( tr );
            };

            const clearFiled = function( name, is_start_price, price ) {
                name.value = '';
                is_start_price.checked = false;
                price.value = '0';
            };

            const createRow = function( name, is_start_price, price, type ) {
                let input_type = document.createElement( 'input' );
                input_type.type = 'hidden';
                input_type.name = 'services[new_' + (new_index) + '][type]';
                input_type.value = type

                let input_status = document.createElement( 'input' );
                input_status.type = 'hidden';
                input_status.name = 'services[new_' + (new_index) + '][status]';
                input_status.value = '1';

                let input_name = document.createElement( 'input' );
                input_name.type = 'text';
                input_name.name = 'services[new_' + (new_index) + '][name]';
                input_name.value = name;
                input_name.className = 'form-control service-name';

                let input_is_start_price = document.createElement( 'input' );
                input_is_start_price.type = 'checkbox';
                input_is_start_price.name = 'services[new_' + (new_index) + '][is_start_price]';
                input_is_start_price.value = '1';
                input_is_start_price.className = 'form-check-input';
                input_is_start_price.checked = is_start_price

                let input_currency = document.createElement( 'input' );
                input_currency.type = 'hidden';
                input_currency.name = 'services[new_' + (new_index) + '][currency]';
                input_currency.value = '{{ \App\Enums\CurrencyTypes::RUB }}';

                let input_price = document.createElement( 'input' );
                input_price.type = 'text';
                input_price.name = 'services[new_' + (new_index) + '][price]';
                input_price.value = price;
                input_price.className = 'form-control';
                input_price.style.width = '100px';

                let button = document.createElement( 'button' );
                button.className = 'btn btn-danger';
                button.innerHTML = '<i class="fa-solid fa-trash-can"></i>';
                button.addEventListener( 'click', removeBtn, false );

                let td_1 = document.createElement( 'td' );
                td_1.append( input_type, input_status, input_name );

                let td_2 = document.createElement( 'td' );
                let div = document.createElement( 'div' );
                div.className = 'form-check';
                div.append( input_is_start_price );
                td_2.append( div );

                let td_3 = document.createElement( 'td' );
                td_3.append( input_currency, input_price );

                let td_4 = document.createElement( 'td' );
                td_4.append( button );

                let tr = document.createElement( 'tr' );
                tr.append( td_1, td_2, td_3, td_4 );

                return tr;
            };

            [...document.querySelectorAll( 'button.service-remove' )].map( bnt => {
                bnt.addEventListener( 'click', removeBtn, false );
            } )

            let tables = [...document.querySelectorAll( '.table-services' )];
            tables.forEach( table => {
                let body = table.querySelector( 'tbody' );
                let foot = table.querySelector( 'tfoot' );
                let [new_name, new_is_start_price, new_price] = [...foot.querySelectorAll( 'input' )];

                // Кнопка очистить и автозаполнить
                let clearBtn = table.parentNode.parentNode.querySelector( '.service-clear' );
                let autoFillBtn = table.parentNode.parentNode.querySelector( '.service-fill' );
                const observer = new MutationObserver( e => {
                    if ( e[ 0 ].target.children.length === 0 ) {
                        clearBtn.setAttribute( 'disabled', 'disabled' )
                        autoFillBtn.removeAttribute( 'disabled' );
                    } else {
                        clearBtn.removeAttribute( 'disabled' );
                        autoFillBtn.setAttribute( 'disabled', 'disabled' )
                    }
                } );
                observer.observe( table.querySelector( 'tbody' ), { childList: true } )

                new_name.addEventListener( 'focus', ( e ) => {
                    e.target.classList.remove( 'is-invalid' );
                }, false );

                new_price.addEventListener( 'focus', ( e ) => {
                    e.target.classList.remove( 'is-invalid' );
                }, false );

                new_is_start_price.addEventListener( 'change', () => {
                    new_price.classList.remove( 'is-invalid' );
                }, false );

                foot.querySelector( 'button' ).addEventListener( 'click', function( e ) {
                    e.preventDefault();

                    // не может быть пустым
                    if( new_name.value === '' ) {
                        new_name.nextElementSibling.textContent = 'Название новой услуги не может быть пустым!'
                        new_name.classList.add( 'is-invalid' );
                        return;
                    }

                    // должно быть уникальным
                    let names = [...body.querySelectorAll( 'input.service-name' )].map( el => el.value );
                    if( names.includes( new_name.value ) ) {
                        new_name.nextElementSibling.textContent = 'Название новой услуги уже присутствует в списке'
                        new_name.classList.add( 'is-invalid' );
                        return;
                    }

                    // если отмечено "От", то надо указать цену
                    if( new_is_start_price.checked && (new_price.value === '0' || new_price.value === '') ) {
                        new_price.nextElementSibling.textContent = 'Нужно указать цену'
                        new_price.classList.add( 'is-invalid' );
                        return;
                    }

                    let tr = createRow( new_name.value, new_is_start_price.checked, new_price.value, this.dataset.type );
                    body.append( tr );

                    new_index++;
                    clearFiled( new_name, new_is_start_price, new_price );
                }, false );
            } );

            [ ...document.querySelectorAll( '.service-clear' ) ].forEach( el => {
                el.addEventListener( 'click', function ( e ) {
                    e.preventDefault();
                    e.target.setAttribute( 'disabled', 'disabled' );
                    e.target.parentNode.parentNode.parentNode.querySelector( 'tbody' ).innerHTML = '';
                }, false )
            } );

            [ ...document.querySelectorAll( '.service-fill' ) ].forEach( el => {
                el.addEventListener( 'click', function( e ) {
                    let type = e.target.dataset.type;
                    let type_id = e.target.dataset.typeid;
                    if ( type in default_services ) {
                        let tbody = e.target.parentNode.parentNode.parentNode.querySelector( 'tbody' );
                        let arr = [];

                        for ( let name of default_services[ type ] ) {
                           let tr = createRow( name, false, 0, type_id );
                           new_index++;
                           arr.push( tr );
                        }

                        tbody.append( ...arr );
                    }
                }, false );
            } );

            [ ...document.querySelectorAll( '.service-type' ) ].forEach( el => {
                el.addEventListener( 'change', function( e ) {
                    [ ...el.parentNode.parentNode.querySelectorAll( '.service-status' ) ].forEach( st => {
                        st.value = +e.target.checked;
                    } );
                }, false );
            } )
        })();
    </script>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
@endpush
