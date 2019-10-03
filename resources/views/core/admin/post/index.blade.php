@extends ('core.layout.app')

@section ('title', __('Posts') )

@section ('main')


<p class="mt-5 mb-10">
    <a href="{{ route('admin.post.create') }}" class="btn btn-purple">
        @lang('Create')
    </a>
</p>


<div class="admin-container">
    <h3 class="admin-h3">@lang('Pages')</h3>

    <table class="w-full">
        <tr class="border-b">
            <th class="table-cell">@lang('Title')</th>
            <th class="hidden lg:table-cell">@lang('Summary')</th>
            <th class="hidden lg:table-cell">@lang('Published at')</th>
            <th class="hidden lg:table-cell">@lang('Views')</th>
            <th class="hidden lg:table-cell">@lang('Comments')</th>
            <th class="table-cell" colspan="2">@lang('Actions')</th>
        </tr>

        @forelse ($posts->where('type', 'page')->sortByDesc('published_at') as $post)
        <tr class="border-b border-grey-light hover:border-blue">
            <td class="table-cell" >
                {{ $post->title }}
            </td>
            <td class="hidden lg:table-cell">{!! $post->summary !!}</td>
            <td class="hidden lg:table-cell @if (!$post->isPublished()) bg-red-lightest @endif">{{ $post->published_at->toFormattedDateString() }}</td>
            <td class="hidden lg:table-cell">{{ $post->views->count() }}</td>
            <td class="hidden lg:table-cell">{{ $post->comments->count() }}</td>
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
        @empty
        <tr>
            <td colspan="6">There are no pages yet.</td>
        </tr>
        @endforelse
    </table>
</div>

<div class="admin-container">
    <h3 class="admin-h3">@lang('Posts')</h3>
    <table class="w-full">
        <tr class="border-b">
            <th class="table-cell">@lang('Title')</th>
            <th class="hidden lg:table-cell">@lang('Summary')</th>
            <th class="hidden lg:table-cell">@lang('Published at')</th>
            <th class="hidden lg:table-cell">@lang('Views')</th>
            <th class="hidden lg:table-cell">@lang('Comments')</th>
            <th class="table-cell" colspan="2">@lang('Actions')</th>
        </tr>
        
        @php
            $future = true;
        @endphp

        @forelse ($posts->where('type', 'post')->sortByDesc('published_at') as $post)
            @php
                if ($future == true && $post->published_at->isPast()) {
                    $future = false;
                }
            @endphp
            <tr class="border-b border-grey-light hover:border-blue @if ($future) bg-blue-lightest @endif ">
                <td class="table-cell" >
                    {{ $post->title }}
                </td>
                <td class="hidden lg:table-cell">{!! $post->summary !!}</td>
                <td class="hidden lg:table-cell @if (!$post->published) bg-red-lightest @endif">{{ $post->published_at->toFormattedDateString() }}</td>
                <td class="hidden lg:table-cell">{{ $post->views->count() }}</td>
                <td class="hidden lg:table-cell">{{ $post->comments->count() }}</td>
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
        @empty
            <tr>
                <td colspan="6">There are no posts yet.</td>
            </tr>
        @endforelse
    </table>
</div>
@endsection