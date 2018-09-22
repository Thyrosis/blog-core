@extends ('core.layout.app')

@section ('title')
    Post :: {{ $post->title }}, {{ $post->longTitle }}
@endsection

@section ('main')
    <div class="admin-container">
        {{ $post->summary }}
    </div>

    <div class="admin-container">
    {!! nl2br($post->body) !!}
    </div>

    <div class="admin-container">
        <p>{{ $post->published_at->toDateString() }}</p>
        <p>@foreach ($post->categories as $category
            {{ $category->name }}
        @endforeach</p>
        <p>@foreach ($post->tags as $tag
            {{ $tag->name }}
        @endforeach</p>
    </div>
@endsection