<?php
/** @var array $filters */
/** @var string $filter_id */
/** @var string $filter_type */
/** @var string $default_value */
/** @var string $selected_value */
?>

@if( isset( $filters ) && !empty( $filters ) )
    <select class="select-filter" id="{{ $filter_id }}">
        <option value="-">{{ $default_value }}</option>
        @foreach( $filters as $item )
            <option
                value="{{ $item->slug }}"
                {{ $selected_value === $item->slug ? 'selected' : '' }}
            >
                {{ $item->name }}
            </option>
        @endforeach
    </select>
    <script type="application/javascript">
        (() => {
            document.querySelector( '#{{ $filter_id }}' ).addEventListener( 'change', ( e ) => {
                let alias = e.target.value;
                if ( alias === '-' ) {
                    window.location.href = '/{{ $filter_type }}/';
                    return;
                }

                window.location.href = '/{{ $filter_type }}/' + alias;
            }, false );
        })();
    </script>
@endif