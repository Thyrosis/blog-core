@php
    echo '<?xml version="1.0" encoding="UTF-8"?>';
@endphp

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach (App\Post::getPublished()->get() as $post)
    <url>

        <loc>{{ $post->link }}</loc>

        <lastmod>{{ $post->published_at->format('Y-m-d') }}</lastmod>

        <changefreq>monthly</changefreq>
    </url>
    @endforeach

</urlset> 
