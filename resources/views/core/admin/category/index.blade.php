@extends ('core.layout.app')

@section ('title')
    Categories
@endsection

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">New Category</h3>
    <p>
        <a href="{{ route('admin.category.create') }}" class="btn btn-teal">
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
        @foreach ($categories as $category)
        <tr class="border-b border-grey-light hover:border-teal-dark">
            <td>{{ $category->name }}</td>
            <td>{{ $category->posts->count() }}</td>
            <td><a href="{{ route('category.show', $category) }}">Posts</td>
            <td><a href="{{ route('admin.category.edit', $category) }}">Edit</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection