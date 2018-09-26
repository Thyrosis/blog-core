@extends ('core.layout.app')

@section ('title')
    Tags
@endsection

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">New Tag</h3>
    <p>
        <a href="{{ route('admin.tag.create') }}" class="btn btn-teal">
            Create
        </a>
    </p>
</div>

<div class="admin-container">
    <h3 class="admin-h3">Index</h3>

    <div class="mb-3">
        <p>An overview of all tags you have defined. Edit names and descriptions or view all posts related to the tag.</p>
    </div>

    <div>
        <table class="w-full">
            <tr class="border-b">
                <th></th>
                <th>Name</th>
                <th>Amount of posts</th>
                <th>View</th>
                <th>Edit</th>
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
                </tr>
            @endforeach
        </table>
    </div>

@endsection