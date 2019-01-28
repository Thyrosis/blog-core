@extends ('core.layout.app')

@section ('title', 'tags')

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">Create new tag</h3>

    <div class="tag flex flex-col lg:flex-row">
        <form id="form_0" name="form_0" method="POST" action="{{ route('admin.tag.store') }}">
            @csrf
        </form>

        <div class="tag-name mr-3">
            <label class="form-label" for="name">Name</label>
            <input form="form_0" type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Name" />
        </div>
        <div class="flex-1 tag-desc mr-3">
            <label class="form-label" for="description">Description</label>
            <input form="form_0" type="text" name="description" id="description" value="{{ old('description') }}" class="w-full form-control" placeholder="Description" />
        </div>
        <div class="tag-actions">
            <label class="form-label">Actions</label>
            <div class="flex">
                <div class="tag-save">
                    <button form="form_0" type="submit" class="m-1 btn-small btn-teal">
                        <i data-feather="save"></i>
                    </button>
                </div>
            </div>
        </div>            
    </div>
</div>


<div class="admin-container">
    <h3 class="admin-h3">Manage your tags</h3>

    <div class="mb-3">
        <p>An overview of all tags you have defined. Edit names and descriptions or view all posts related to the tag.</p>
        <p>Removing a tag will only get rid of the tag itself. Posts will remain published and available but will no longer be associated with the specific tag.</p>
    </div>

    <div>
        @foreach ($tags as $tag)
        
        <div class="tag flex flex-col lg:flex-row">
            <form id="form_{{ $tag->id }}" name="form_{{ $tag->id }}" method="POST" action="{{ route('admin.tag.update', $tag) }}">
                @csrf
                @method('PATCH')
            </form>

            <div class="tag-name mr-3">
                <label class="form-label" for="name">Name</label>
                <input form="form_{{ $tag->id }}" type="text" name="name" id="name" value="{{ old('name', $tag->name) }}" class="form-control" />
            </div>
            <div class="flex-1 tag-desc mr-3">
                <label class="form-label" for="description">Description</label>
                <input form="form_{{ $tag->id }}" type="text" name="description" id="description" value="{{ old('description', $tag->description) }}" class="form-control" />
            </div>
            <div class="tag-actions">
                <label class="form-label">Actions</label>
                <div class="flex">
                    <div class="tag-save">
                        <button form="form_{{ $tag->id }}" type="submit" class="m-1 btn-small btn-teal">
                            <i data-feather="save"></i>
                        </button>
                    </div>
                    <div class="tag-posts">
                        <a href="{{ route('tag.show', $tag) }}" target="_blank" class="flex items-center m-1 btn-small btn-blue text-blue-darkest">
                            <div class="mr-2">{{ $tag->posts->count() }}</div> 
                            <i data-feather="list"></i>
                        </a>
                    </div>
                    <div class="tag-remove">
                        <form id="form_delete_{{ $tag->id }}" name="form_delete_{{ $tag->id }}" method="POST" action="{{ route('admin.tag.destroy', $tag) }}" class="mb-0">
                            @csrf
                            @method('DELETE')

                            <button form="form_delete_{{ $tag->id }}" type="submit" class="m-1 btn-small btn-red">
                                <i data-feather="trash-2"></i>
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