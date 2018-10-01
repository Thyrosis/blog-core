<div class="admin-container">
    <h3 class="admin-h3">{{ $post->title }}</h3>
    
    <div>
        <p>{!! $post->getSummary() !!}</p>
    </div>

    <div class="mt-5">
        <a href="{{ $post->path() }}">Read on</a>
    </div>
</div>