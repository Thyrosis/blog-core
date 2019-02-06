@extends ('core.layout.app')

@section ('title', __('Comments'))

@section ('main')

<form method="POST" action="{{ route('admin.comment.update', $comment) }}" >
    @csrf
    @method ('PATCH')

    <div class="admin-container">
        <h3 class="admin-h3">@lang('Edit comment')</h3>

        <div class="mb-5">
            <label for="name" class="form-label">@lang('Name')</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $comment->name) }}" />
            <p class="form-info">@lang('Comment poster')</p>

            @if ($errors->has('name'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('name') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="emailaddress" class="form-label">@lang('E-mail Address')</label>
            <input type="email" id="emailaddress" name="emailaddress" class="form-control" value="{{ old('emailaddress', $comment->emailaddress) }}" />
            <p class="form-info">@lang('Commenter\'s e-mail address')</p>

            @if ($errors->has('emailaddress'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('emailaddress') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="body" class="form-label">@lang('Comment')</label>
            <textarea id="body" name="body" class="form-control tinymce-slim" >{{ old('body', $comment->body) }}</textarea>
            <p class="form-info">@lang('The actual comment')</p>

            @if ($errors->has('body'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('body') }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="admin-container">
        <h3 class="admin-h3">@lang('Actions')</h3>

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">@lang('Save')</button>
            <button type="reset" class="btn btn-grey">@lang('Reset')</button>
            <a href="{{ route('admin.comment.destroy', $comment) }}" onclick="return confirm('Are you sure you want to delete this post? It cannot be undone!');" class="btn btn-red">@lang('Delete')</a>
        </div>
    </div>
</form>
@endsection
