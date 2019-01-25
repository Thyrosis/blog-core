@extends ('core.layout.app')

@section ('title', 'Tags')

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">Manage your tags</h3>

    <div class="mb-3">
        <p>An overview of all tags you have defined. Edit names and descriptions or view all posts related to the tag.</p>
        <p>Removing a tag will only get rid of the tag itself. Posts will remain published and available but will no longer be associated with the specific tag.</p>
    </div>

    <div>
        <table class="w-full">
            <tr class="border-b">
                <th colspan="2">Name</th>
                <th>Description</th>
                <th>Save</th>
                <th>Posts</th>
                <th>Remove</th>
            </tr>
            
            @foreach ($tags as $tag)
                <tr>
                    <td>
                        <form id="form_{{ $tag->id }}" name="form_{{ $tag->id }}" method="POST" action="{{ route('admin.tag.update', $tag) }}">
                            @csrf
                            @method('PATCH')
                        </form>
                    </td>

                    <td>
                        <input form="form_{{ $tag->id }}" type="text" name="name" id="name" value="{{ old('name', $tag->name) }}" class="m-1 p-2 shadow border border-teal rounded focus:shadow-inner" />
                    </td>
                    <td class="w-full">
                        <input form="form_{{ $tag->id }}" type="text" name="description" id="description" value="{{ old('description', $tag->description) }}" class="w-full m-1 p-2 shadow border border-teal rounded focus:shadow-inner" />
                    </td>
                    <td>
                        <button form="form_{{ $tag->id }}" type="submit" class="m-1 btn btn-teal">
                            <i data-feather="save"></i>
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('tag.show', $tag) }}" target="_blank" class="flex items-center m-1 btn btn-blue text-blue-darkest">
                            <div class="mr-2">{{ $tag->posts->count() }}</div> 
                            <i data-feather="list"></i>
                        </a>
                    </td>
                    <td>
                        <form id="form_delete_{{ $tag->id }}" name="form_delete_{{ $tag->id }}" method="POST" action="{{ route('admin.tag.destroy', $tag) }}" class="mb-0">
                            @csrf
                            @method('DELETE')

                            <button form="form_delete_{{ $tag->id }}" type="submit" class="m-1 btn btn-red">
                                <i data-feather="trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            <tr>
                <th colspan="4">Add a new tag</th>
            </tr>

            <tr>
                <td>
                    <form id="form_0" name="form_0" method="POST" action="{{ route('admin.tag.store') }}">
                        @csrf
                    </form>
                </td>
                <td>
                    <input form="form_0" type="text" name="name" id="name" value="{{ old('name') }}" class="m-1 p-2 shadow border border-teal rounded focus:shadow-inner" placeholder="Name" />
                </td>
                <td class="w-full">
                    <input form="form_0" type="text" name="description" id="description" value="{{ old('description') }}" class="w-full m-1 p-2 shadow border border-teal rounded focus:shadow-inner" placeholder="Description" />
                </td>
                <td>
                    <button form="form_0" type="submit" class="m-1 btn btn-teal">
                        <i data-feather="save"></i>
                    </button>
                </td>
                <td>
                    &nbsp;
                </td>
            </tr>
        </table>
    </div>

@endsection