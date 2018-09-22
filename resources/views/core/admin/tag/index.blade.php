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