<?php
/** @var string $name */
/** @var string $title */
/** @var string $type */
/** @var array $data */
/** @var array $selected */
/** @var string $specialization_type */
/** @var int $route_param_number */
?>

<div class="card works-filter" data-filter-type="{{ $name }}">
    <div class="card-header">
        {{ $title }}
    </div>
    <div class="card-body">
        @if ( $type === 'Checkbox' )
            @foreach( $data as $id => $item )
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        value="{{ $item->slug }}"
                        id="filters_{{ $id }}"
                        {{ in_array( $item->slug, $selected, false ) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="filters_{{ $id }}">
                        <a data-filter="{{ $item->slug }}" href="{{ route( 'search.' . $specialization_type, [ 'filter' => $item->slug ] ) }}">{{ $item->name }}</a>
                    </label>
                </div>
            @endforeach
        @elseif ( $type === 'Range' )
            <div class="row">
                @foreach( $data as $i => $item )
                    <div class="col-sm-6">
                        <input type="text" class="form-control mb-0" name="{{ $name . '[' . $i . ']' }}" placeholder="{{ $item }}" value="{{ $selected[$i] ?? '' }}">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
