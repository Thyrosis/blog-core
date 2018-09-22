@extends ('core.layout.app')

@section ('title')
    Comments
@endsection

@section ('main')

<form method="POST" action="{{ route('admin.comment.update', $comment) }}" >
    @csrf
    @method ('PATCH')

    <div class="admin-container">
        <h3 class="admin-h3">Edit comment</h3>

        <div class="mb-5">
            <label for="name" class="text-grey-darker text-sm font-bold mb-2 block">Name</label>
            <input type="text" id="name" name="name" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" value="{{ old('name', $comment->name) }}" />
            <p class="form-info">Comment poster</p>

            @if ($errors->has('name'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('name') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="emailaddress" class="text-grey-darker text-sm font-bold mb-2 block">Email Address</label>
            <input type="email" id="emailaddress" name="emailaddress" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" value="{{ old('emailaddress', $comment->emailaddress) }}" />
            <p class="form-info">Commenter's email address</p>

            @if ($errors->has('emailaddress'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('emailaddress') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="body" class="text-grey-darker text-sm font-bold mb-2 block">Comment</label>
            <textarea id="body" name="body" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner tinymce" >{{ old('body', $comment->body) }}</textarea>
            <p class="form-info">Comment text</p>

            @if ($errors->has('body'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('body') }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="admin-container">
        <h3 class="admin-h3">Extra info</h3>

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">Opslaan</button>
            <button type="reset" class="btn btn-grey">Reset</button>
            <a href="{{ route('admin.comment.destroy', $comment) }}" onclick="return confirm('Are you sure you want to delete this post? It cannot be undone!');" class="btn btn-red">Delete</a>
        </div>
    </div>
</form>
@endsection
