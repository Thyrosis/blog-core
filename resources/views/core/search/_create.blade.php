<div class="admin-container">
    <form method="POST" action="{{ route('search.store') }}">
        @csrf       

        <div class="mb-5">
            <label class="form-label" for="term">@lang('Search for...')</label>
            <input class="form-control" id="term" name="term" required type="text" value="{{ old('term') }}" />
            <p class="form-info">@lang('We\'ll search in title, summary and body for you.')</p>

            @if ($errors->has('term'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('term') }}</span>
                </div>
            @endif
        </div>

        <div class="form-button-group">
            <button type="submit" class="btn btn-purple">@lang('Search')</button>
        </div>
    </form>
</div>