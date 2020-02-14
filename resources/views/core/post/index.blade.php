@extends ('core.layout.app')

@section ('main')

    <h2>Featured posts</h2>

    @if ($post = App\Post::getFeaturedPost())
        @includeFirst(['core.category._single', 'core.post._single'], ['post' => $post])
    @endif

    @forelse (App\Post::getFeaturedPosts() as $post)
        @includeFirst(['core.category._single', 'core.post._single'], ['post' => $post])
    @empty
        No featured posts to show.
    @endforelse


    <h2>Normal posts</h2>
    @foreach ($posts as $post)
        @includeFirst(['core.category._single', 'core.post._single'], ['post' => $post])
    @endforeach

    {{ $posts->links() }} 

    @include ('core.search._create')
    
@endsection