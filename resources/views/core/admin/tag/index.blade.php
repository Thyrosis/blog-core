@extends ('core.layout.app')

@section ('title', __('Tags'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang('Create new tag')</h3>

    <div class="tag flex flex-col lg:flex-row">
        <form id="form_0" name="form_0" method="POST" action="{{ route('admin.tag.store') }}">
            @csrf
        </form>

        <div class="tag-name mr-3">
            <label class="form-label" for="name">@lang('Name')</label>
            <input form="form_0" type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="@lang('Your Name')" />
        </div>
        <div class="flex-1 tag-desc mr-3">
            <label class="form-label" for="description">@lang('Description')</label>
            <input form="form_0" type="text" name="description" id="description" value="{{ old('description') }}" class="form-control" placeholder="Description" />
        </div>
        <div class="tag-actions">
            <label class="form-label">@lang('Actions')</label>
            <div class="flex">
                <div class="tag-save">
                    <button form="form_0" type="submit" class="btn btn-small btn-green">
                        <i data-feather="save"></i>
                    </button>
                </div>
            </div>
        </div>            
    </div>
</div>


<div class="admin-container">
    <h3 class="admin-h3">@lang('Manage your tags')</h3>

    <div class="mb-3">
        @lang('<p>An overview of all tags you have defined. Edit names and descriptions or view all posts related to the tag.</p><p>Removing a tag will only get rid of the tag itself. Posts will remain published and available but will no longer be associated with the specific tag.</p>')
    </div>

    <div>
        <div class="tag hidden lg:flex lg:flex-row">
            <div class="cat-name mr-3 lg:w-1/5">
                <label class="form-label" for="name">@lang('Name')</label>
            </div>
            <div class="flex-1 cat-desc mr-3 lg:w-3/5">
                <label class="form-label" for="description">@lang('Description')</label>
            </div>
            <div class="cat-actions lg:w-1/5">
                <label class="form-label">@lang('Actions')</label>
            </div>
        </div>

        @forelse ($tags as $tag)
        <div class="tag flex flex-col lg:flex-row lg:mb-2">
            <form id="form_{{ $tag->id }}" name="form_{{ $tag->id }}" method="POST" action="{{ route('admin.tag.update', $tag) }}">
                @csrf
                @method('PATCH')
            </form>

            <div class="cat-name mr-3 lg:w-1/5">
                <label class="form-label block lg:hidden" for="name">@lang('Name')</label>
                <input form="form_{{ $tag->id }}" type="text" name="name" id="name" value="{{ old('name', $tag->name) }}" class="form-control" />
            </div>
            <div class="flex-1 cat-desc mr-3 lg:w-3/5">
                <label class="form-label block lg:hidden" for="description">@lang('Description')</label>
                <input form="form_{{ $tag->id }}" type="text" name="description" id="description" value="{{ old('description', $tag->description) }}" class="form-control" />
            </div>
            <div class="cat-actions lg:w-1/5">
                <label class="form-label block lg:hidden">@lang('Actions')</label>
                <div class="flex">
                    <div class="cat-save">
                        <button form="form_{{ $tag->id }}" type="submit" class="btn btn-small btn-green">
                            <i data-feather="save"></i>
                        </button>
                    </div>
                    <div class="cat-posts">
                        <a href="{{ route('tag.show', $tag) }}" target="_blank" class="flex items-center btn btn-small btn-blue">
                            <div class="mr-2">{{ $tag->posts->count() }}</div> 
                            <i data-feather="list"></i>
                        </a>
                    </div>
                    <div class="cat-remove">
                        <form id="form_delete_{{ $tag->id }}" name="form_delete_{{ $tag->id }}" method="POST" action="{{ route('admin.tag.destroy', $tag) }}" class="mb-0">
                            @csrf
                            @method('DELETE')

                            <button form="form_delete_{{ $tag->id }}" type="submit" class="btn btn-small btn-red">
                                <i data-feather="trash-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>            
        </div>
        @empty
        <div>
            <p class="italic">@lang('There are no tags yet.')</p>
        </div>
        @endforelse
    </div>
</div>

@endsection