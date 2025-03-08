@guest
    <p>
        {{ __( 'The protected area.' ) }} 2022 - {{date('Y')}}
    </p>
@else

    <div class="text-center user-select-none">
        <p class="small m-0">
            {{ __( 'The protected area.' ) }} 2022 - {{date('Y')}}<br>
        </p>
    </div>
@endguest
