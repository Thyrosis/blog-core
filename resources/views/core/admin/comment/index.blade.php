@extends ('core.layout.app')

@section ('title', __('Comments'))

@section ('main')
<div class="admin-container">
    <h3 class="admin-h3">@lang('All comments')</h3>
    @forelse ($comments as $comment)
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
                <a href="{{ route('post.show', $comment->post) }}#{{ $comment->id }}" target="_blank" class="no-underline btn-blue-text">
                    <i data-feather="eye"></i>
                </a>&nbsp;

                <a class="btn-purple-text" href="{{ route('admin.comment.edit', $comment) }}">
                    <i  data-feather="edit-3"></i>
                </a>&nbsp;

                <form class="m-0" method="POST" action="{{ route('admin.comment.update', $comment) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="approved" value="{{ ($comment->approved) ? '0' : '1' }}" />

                    @if (!$comment->approved)
                    <button type="submit">
                        <i class="btn-green-text" data-feather="thumbs-up"></i>
                    </button>
                    @else
                    <button type="submit">
                        <i class="btn-orange-text" data-feather="thumbs-down"></i>
                    </button>
                    @endif
                </form>&nbsp;

                <form class="m-0" method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.comment.destroy', $comment) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        <i class="btn-red-text" data-feather="trash-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
        <p>@lang('No comments have been posted yet.')</p>
    @endforelse

</div>
@endsection