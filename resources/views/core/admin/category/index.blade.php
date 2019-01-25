@extends ('core.layout.app')

@section ('title', 'Categories')

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">Create new category</h3>

    <div class="category flex flex-col lg:flex-row">
        <form id="form_0" name="form_0" method="POST" action="{{ route('admin.category.store') }}">
            @csrf
        </form>

        <div class="cat-name mr-3">
            <label class="form-label" for="name">Name</label>
            <input form="form_0" type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Name" />
        </div>
        <div class="flex-1 cat-desc mr-3">
            <label class="form-label" for="description">Description</label>
            <input form="form_0" type="text" name="description" id="description" value="{{ old('description') }}" class="w-full form-control" placeholder="Description" />
        </div>
        <div class="cat-actions">
            <label class="form-label">Actions</label>
            <div class="flex">
                <div class="cat-save">
                    <button form="form_0" type="submit" class="m-1 btn-small btn-teal">
                        <i data-feather="save"></i>
                    </button>
                </div>
            </div>
        </div>            
    </div>
</div>


<div class="admin-container">
    <h3 class="admin-h3">Manage your categories</h3>

    <div class="mb-3">
        <p>An overview of all categories you have defined. Edit names and descriptions or view all posts related to the category.</p>
        <p>Removing a category will only get rid of the category itself. Posts will remain published and available but will no longer be associated with the specific category.</p>
    </div>

    <div>
        @foreach ($categories as $category)
        
        <div class="category flex flex-col lg:flex-row">
            <form id="form_{{ $category->id }}" name="form_{{ $category->id }}" method="POST" action="{{ route('admin.category.update', $category) }}">
                @csrf
                @method('PATCH')
            </form>

            <div class="cat-name mr-3">
                <label class="form-label" for="name">Name</label>
                <input form="form_{{ $category->id }}" type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="form-control" />
            </div>
            <div class="flex-1 cat-desc mr-3">
                <label class="form-label" for="description">Description</label>
                <input form="form_{{ $category->id }}" type="text" name="description" id="description" value="{{ old('description', $category->description) }}" class="form-control" />
            </div>
            <div class="cat-actions">
                <label class="form-label">Actions</label>
                <div class="flex">
                    <div class="cat-save">
                        <button form="form_{{ $category->id }}" type="submit" class="m-1 btn-small btn-teal">
                            <i data-feather="save"></i>
                        </button>
                    </div>
                    <div class="cat-posts">
                        <a href="{{ route('category.show', $category) }}" target="_blank" class="flex items-center m-1 btn-small btn-blue text-blue-darkest">
                            <div class="mr-2">{{ $category->posts->count() }}</div> 
                            <i data-feather="list"></i>
                        </a>
                    </div>
                    <div class="cat-remove">
                        <form id="form_delete_{{ $category->id }}" name="form_delete_{{ $category->id }}" method="POST" action="{{ route('admin.category.destroy', $category) }}" class="mb-0">
                            @csrf
                            @method('DELETE')

                            <button form="form_delete_{{ $category->id }}" type="submit" class="m-1 btn-small btn-red">
                                <i data-feather="trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>            
        </div>
        @endforeach
    </div>
</div>

@endsection