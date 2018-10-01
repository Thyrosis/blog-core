<div class="admin-container">
    <h3 class="admin-h3">Search</h3>

    <form method="POST" action="{{ route('search.store') }}">
        @csrf       

        <div class="mb-5">
            <label for="term" class="text-grey-darker text-sm font-bold mb-2 block">Search for...</label>
            <input type="text" name="term" id="term" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required value="{{ old('term') }}" />
            <p class="form-info">We'll search in title, summary and body for you.</p>

            @if ($errors->has('term'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('term') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">Search</button>
        </div>
    </form>
</div>