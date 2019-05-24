<div class="admin-container">
    <h3 class="admin-h3">@lang('Search')</h3>

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

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">@lang('Search')</button>
        </div>
    </form>
</div>