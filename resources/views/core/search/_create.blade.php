<div class="admin-container">
    <h3 class="admin-h3">Zoeken</h3>

    <form method="POST" action="{{ route('search.store') }}">
        @csrf       

        <div class="mb-5">
            <label for="term" class="text-grey-darker text-sm font-bold mb-2 block">Zoeken naar...</label>
            <input type="text" name="term" id="term" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required value="{{ old('term') }}" />
            <p class="form-info">Wordt een URL van gemaakt en toont op de voorpagina</p>

            @if ($errors->has('term'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('term') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">Zoeken</button>
        </div>
    </form>
</div>