@extends ('core.layout.app')

@section ('title', __('Comments'))

@section ('main')
<div class="admin-container">
    @foreach ($comments as $comment)
    <div class="comment flex flex-col lg:flex-row @if (!$comment->approved) admin-comment-unapproved @endif mb-2 pl-2">
        <div class="comment-name mr-3 lg:w-1/6">
            <label class="form-label" for="name">@lang('Name')</label>
            {{ $comment->name }} <br /> <small class="overflow-hidden">{{ $comment->emailaddress }}</small>
        </div>

        <div class="flex-1 comment-desc mr-3">
            <label class="form-label" for="content">{{ $comment->created_at->diffForHumans() }}<span class="font-normal"> @lang('on') </span>{{ $comment->post->title }}</label> 
            {{ $comment->body }}
        </div>

        <div class="comment-actions ">
            <label class="form-label">@lang('Actions')</label>
            <div class="flex">
                <a href="{{ route('post.show', $comment->post) }}#{{ $comment->id }}" target="_blank" class="no-underline">
                    <i class="text-purple-700" class="text-teal" data-feather="eye"></i>
                </a>&nbsp;

                <a href="{{ route('admin.comment.edit', $comment) }}"><i class="text-grey-darker" data-feather="edit-3"></i></a>&nbsp;

                <form class="m-0" method="POST" action="{{ route('admin.comment.update', $comment) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="approved" value="{{ ($comment->approved) ? '0' : '1' }}" />

                    @if (!$comment->approved)
                    <button type="submit"><i class="text-green-500" data-feather="thumbs-up"></i></button>
                    @else
                    <button type="submit"><i class="text-orange-500" data-feather="thumbs-down"></i></button>
                    @endif
                </form>&nbsp;

                <form class="m-0" method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.comment.destroy', $comment) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><i class="text-red-700" data-feather="trash-2"></i></button>
                </form>
            </div>
        </div>
    </div>

    <hr class="border-b border-teal lg:hidden" />
    @endforeach

    <!--<table class="w-full">
        <tr class="border-b">
            <th class="table-cell">@lang('Name')</th>
            <th class="hidden lg:table-cell">@lang('E-mail Address')</th>
            <th class="table-cell">@lang('Post')</th>
            <th class="table-cell">@lang('Content')</th>
            <th class="hidden lg:table-cell">@lang('Date')</th>
            <th class="table-cell" colspan="3">@lang('Actions')</th>
        </tr>

        @foreach ($comments as $comment)
        <tr class="border-b border-grey-light hover:border-teal @if (!$comment->approved) bg-red-lightest @endif ">
            <td class="table-cell">{{ $comment->name }}</a></td>
            <td class="hidden lg:table-cell">{{ $comment->emailaddress }}</td>
            <td class="table-cell"><a href="{{ route('post.show', $comment->post) }}" target="_blank">{{ $comment->post->title }}</a></td>
            <td class="table-cell">{!! $comment->body !!}</td>
            <td class="hidden lg:table-cell">{{ $comment->created_at->format('jM') }}</td>
            <td class="table-cell">
                <a href="{{ route('admin.comment.edit', $comment) }}"><i class="text-teal" data-feather="edit-3"></i></a>
            </td>
            <td class="table-cell">
                <form class="m-0" method="POST" action="{{ route('admin.comment.update', $comment) }}">
                    @csrf 
                    @method('PATCH')
                    <input type="hidden" name="approved" value="{{ ($comment->approved) ? '0' : '1' }}" />

                    @if (!$comment->approved)
                        <button type="submit"><i class="text-green" data-feather="thumbs-up"></i></button>
                    @else
                        <button type="submit"><i class="text-red-dark" data-feather="thumbs-down"></i></button>
                    @endif
                </form>
            </td>
            <td class="table-cell">
                <form class="m-0" method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.comment.destroy', $comment) }}">
                    @csrf 
                    @method('DELETE') 
                    <button type="submit"><i class="text-grey-darkest" data-feather="trash-2"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>-->


</div>
@endsection