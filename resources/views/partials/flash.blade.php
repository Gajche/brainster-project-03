<div id="flash-messages" class="hidden" aria-hidden="true">
    {{-- Success Message --}}
    @if(session('success'))
        <div id="flash-success-data" data-message="{{ session('success') }}"></div>
    @endif

    {{-- General Error --}}
    @if($errors->has('general'))
        <div id="flash-error-data" data-message="{{ $errors->first('general') }}"></div>
    @endif

    {{-- All Validation Errors --}}
    @if($errors->any() && !$errors->has('general'))
        @foreach($errors->all() as $error)
            <div class="flash-validation-error" data-message="{{ $error }}"></div>
        @endforeach
    @endif
</div>