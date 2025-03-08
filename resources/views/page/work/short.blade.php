<?php
/** @var \App\Models\File $file */
/** @var array $dictionaries */
/** @var string $type */
?>

@php
    $attr = $file?->fileInfo->attribute[ 'c' . $file->album->type ] ?? [];
    $file_name = $file->fileInfo?->name ?? '';
    $is_info = $file->fileInfo?->name || $file->fileInfo?->description || !empty( $attr );
@endphp

<div class="short-work" style="max-width: 968px;">
    <div class="container-fluid">
        <div class="row">
            <div class="@if( $is_info ) col-8 @else col-12 @endif p-0">
                <img
                    src="{{ Storage::url( 'images/original/' . $file->original ) }}"
                    alt="{{ $file_name ?: \App\Helpers\DictionaryHelper::getDictionariesAsStringByAttributes( $dictionaries, $attr ) }}"
                    class="img-fluid w-100"
                >
            </div>

            @if ( $is_info )
            <div class="col-4 short-work-info" style="background: #fff;">
                <div class="mt-2">
                    @if ( $file_name )
                        <h2 class="mb-2">{{ $file_name }}</h2>
                    @endif

                    @if ( $file->fileInfo?->description )
                        <p class="mb-2">{{ $file->fileInfo?->description }}</p>
                    @endif

                    <div class="work-tags">
                        @foreach( $dictionaries as $k => $item )
                            @continue( ( $item[ 'data' ][ $attr[ 'd' . $item[ 'id' ] ][ 0 ] ?? 0 ] ?? null ) === null )
                            <a
                                href="{{ \App\Helpers\SearchRoutesHelper::getRouteForWorkTag( $type, $item[ 'data' ], $attr[ 'd' . $item[ 'id' ] ][ 0 ] ?? null ) }}"
                                target="_blank"
                            >#{{ mb_strtolower( \App\Helpers\DictionaryHelper::getNameByAttribute( $item[ 'data' ], $attr[ 'd' . $item[ 'id' ] ][ 0 ] ?? null ) ) }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
