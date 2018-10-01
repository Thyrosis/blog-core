@extends ('core.layout.app')

@section ('main')

    <div class="admin-container">
        <h3 class="admin-h3">{{ $tag->name }}</h3>
        <p>{{ $tag->description }}</p>
    </div>

    @foreach ($posts as $post)
        @includeFirst(['core.tag._single', 'core.post._single'], ['post' => $post])
    @endforeach

    {{ $posts->links() }} 

@endsection