<fieldset class="row g-0 mb-3">
    <div class="col-12 {{!$vertical ? 'col-md-7' : ''}} shadow-sm">

        <div class="bg-white d-flex flex-column layout-wrapper {{ empty($commandBar) ? 'rounded' : 'rounded-top' }}">
            @foreach($manyForms as $key => $layouts)
                @foreach($layouts as $layout)
                    {!! $layout ?? '' !!}
                @endforeach
            @endforeach
        </div>

        @empty(!$commandBar)
            <div class="bg-light px-4 py-3 d-flex justify-content-end rounded-bottom">
                @foreach($commandBar as $command)
                    {!! $command !!}
                @endforeach
            </div>
        @endempty
    </div>
</fieldset>

