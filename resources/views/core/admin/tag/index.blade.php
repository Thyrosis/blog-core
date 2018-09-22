@extends ('core.layout.app')

@section ('title')
    Tags
@endsection

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">New Tag</h3>

    <form method="POST" action="{{ route('admin.tag.store') }}" class="w-full max-w-sm">
        {{ csrf_field() }}
        <div class="flex items-center border-b border-b-2 border-teal py-2">
            <input name="name" id="name" required class="appearance-none bg-transparent border-none w-full text-grey-darker mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Tag Name" aria-label="Tag Name">
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

<div class="admin-container">
    <h3 class="admin-h3">Index</h3>

    <table>
        <tr class="border-b">
            <th>Name</th>
            <th>Amount of posts</th>
            <th>View</th>
            <th>Edit</th>
        </tr>
        @foreach ($tags as $tag)
        <tr class="border-b border-grey-light hover:border-teal-dark">
            <td>{{ $tag->name }}</td>
            <td>{{ $tag->posts->count() }}</td>
            <td><a href="{{ route('tag.show', $tag) }}">Posts</td>
            <td><a href="{{ route('admin.tag.edit', $tag) }}">Edit</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection