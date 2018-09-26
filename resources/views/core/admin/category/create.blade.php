@extends ('core.layout.app')

@section ('title')
    Categories
@endsection

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">New Category</h3>

    <form method="POST" action="{{ route('admin.category.store') }}">
        @csrf
        
        <div class="">
            <div class="mb-5">
                <label for="name" class="text-grey-darker text-sm font-bold mb-2 block">Name</label>
                <input type="text" id="name" name="name" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required value="{{ old('name') }}" />
                <p class="form-info">Name of the category. As descriptive as possible. Will be turned into a URL-friendly slug too.</p>

                @if ($errors->has('name'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('name') }}</span>
                    </div>
                @endif
            </div>  

            <div class="mb-5">
                <label for="description" class="text-grey-darker text-sm font-bold mb-2 block">Description</label>
                <textarea id="description" name="description" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner tinymce" >{{ old('description') }}</textarea>
                <p class="form-info">Description of the category. Can be show anywhere the template dictates, like anchor-titles or META descriptions in category pages.</p>

                @if ($errors->has('description'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('description') }}</span>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-teal">
                Add
            </button>
        </div>
        
        @if ($errors->has('name'))
            <div class="form-error">
                <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('name') }}</span>
            </div>
        @endif
    </form>
</div>
@endsection