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
            <th class="hidden lg:table-cell">@lang('Comments')</th>
            <th class="table-cell" colspan="2">@lang('Actions')</th>
        </tr>

        @php
            $future = true;
        @endphp

        @forelse ($posts->where('type', 'page')->sortByDesc('published_at') as $page)
            @php
                if ($future == true && $page->published_at->isPast()) {
                    $future = false;
                }
            @endphp
        <tr class="border-b border-gray-300 hover:border-blue-800 @if (!$page->published) bg-red-200 @elseif ($future) bg-blue-200 @endif">
            <td class="table-cell" >
                {{ $page->title }}
            </td>
            <td class="hidden lg:table-cell">{!! $page->summary !!}</td>
            <td class="hidden lg:table-cell">{{ $page->published_at->toFormattedDateString() }}</td>
            <td class="hidden lg:table-cell">{{ $page->comments->count() }}</td>
            <td class="table-cell">
                <a href="{{ route('admin.post.edit', $page) }}" class="btn-purple-text">
                    <i data-feather="edit-3"></i>
                </a>
            </td>
            <td class="table-cell">
                <a href="{{ route('post.show', $page) }}" target="_blank" class="btn-blue-text">
                    <i data-feather="eye"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td class='italic' colspan="6">@lang('There are no pages yet.')</td>
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
            <tr class="border-b border-gray-300 hover:border-blue-800 @if (!$post->published) bg-red-200 @elseif ($future) bg-blue-200 @endif ">
                <td class="table-cell" >
                    {{ $post->title }}
                </td>
                <td class="hidden lg:table-cell">{!! $post->summary !!}</td>
                <td class="hidden lg:table-cell">{{ $post->published_at->toFormattedDateString() }}</td>
                <td class="hidden lg:table-cell">{{ $post->comments->count() }}</td>
                <td class="table-cell">
                    <a href="{{ route('admin.post.edit', $post) }}" class="btn-purple-text">
                        <i data-feather="edit-3"></i>
                    </a>
                </td>
                <td class="table-cell">
                    <a href="{{ route('post.show', $post) }}" target="_blank" class="btn-blue-text">
                        <i data-feather="eye"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td class='italic' colspan="6">@lang('There are no posts yet.')</td>
            </tr>
        @endforelse
    </table>
</div>
@endsection