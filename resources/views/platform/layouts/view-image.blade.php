<?php
/** @var string $original */
?>
<div class="pt-5 ps-5 pb-4">
    @if ( ( $original ?? '' ) !== '' )
        <img class="img-fluid" alt="preview" src="/storage/images/original/{{ $original }}">
    @endif
</div>
