@extends ('core.layout.app')

@section ('title', 'Posts')

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">New Post</h3>
    <p>
        <a href="{{ route('admin.post.create') }}" class="btn btn-teal">
            Create
        </a>
    </p>
</div>

<div class="admin-container">
    <h3 class="admin-h3">Index</h3>

    <table class="w-full">
        <tr class="border-b">
            <th class="table-cell">Title</th>
            <th class="hidden lg:table-cell">Longtitle</th>
            <th class="hidden lg:table-cell">Published at</th>
            <th class="hidden lg:table-cell">Views</th>
            <th class="table-cell" colspan="2">Actions</th>
        </tr>
        @foreach ($posts->sortByDesc('published_at') as $post)
        <tr class="border-b border-grey-light hover:border-blue">
            <td class="table-cell" >
                {{ $post->title }}
            </td>
            <td class="hidden lg:table-cell">{{ $post->longTitle }}</td>
            <td class="hidden lg:table-cell @if (!$post->isPublished()) bg-red-lightest @endif">{{ $post->published_at->toFormattedDateString() }}</td>
            <td class="hidden lg:table-cell">{{ $post->views }}</td>
            <td class="table-cell">
                <a href="{{ route('post.show', $post) }}" target="_blank" class="no-underline">
                    <i class="text-grey-darkest" class="text-teal" data-feather="eye"></i>
                </a>
            </td>
            <td class="table-cell">
                <a href="{{ route('admin.post.edit', $post) }}" class="no-underline">
                    <i class="text-teal" data-feather="edit-3"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection