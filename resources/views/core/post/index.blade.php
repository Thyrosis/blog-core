@extends ('core.layout.app')

@section ('main')

    @if (isset($category))
        <div class="admin-container">
            <h3 class="admin-h3">{{ $category->name }}</h3>
        </div>
    @endif

    @foreach ($posts as $post)
        <div class="admin-container">
            <h3 class="admin-h3">{{ $post->title }}</h3>
            
            <div>
                <p>{{ $post->getSummary() }}</p>
            </div>

            <div class="mt-5">
                <a href="{{ $post->path() }}">Read on</a>
            </div>
        </div>
    @endforeach

    {{ $posts->links() }} 

    @include ('core.search._create')

@endsection