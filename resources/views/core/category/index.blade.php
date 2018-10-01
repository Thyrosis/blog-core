@extends ('core.layout.app')

@section ('main')

    <div class="admin-container">
        <h3 class="admin-h3">{{ $category->name }}</h3>
        <p>{{ $category->description }}</p>
    </div>

    @foreach ($posts as $post)
        @includeFirst(['core.category._single', 'core.post._single'], ['post' => $post])
    @endforeach

    {{ $posts->links() }} 

@endsection