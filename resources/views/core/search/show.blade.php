@extends ('core.layout.app')

@section ('main')
    <div class="admin-container">
        <h3 class="admin-h3">@lang('Search Results')</h3>
        <p>You've searched for the term <strong>{{ $search->term }}</strong>. These are the results we found for you:</p>
    </div>

    @forelse ($posts as $post)
        @includeFirst(['core.category._single', 'core.post._single'], ['post' => $post])
    @empty
        <div class="admin-container">
            <h3 class="admin-h3">@lang('No results found')</h3>
            
            <div>
                <p>Searching for {{ $search->term }} apparently didn't yield any results. Why not try to search for something else?</p>
            </div>

        </div>
    @endforelse

    @include ('core.search._create')
@endsection