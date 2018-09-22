@extends ('core.layout.app')

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">{{ $post->title }}</h3>

    <h4>{{ $post->user->name ?? config('app.defaultAuthor') }} @ {{ $post->published_at }}</h4>

    <div>
        {!! $post->body !!}
    </div>
</div>

<div class="admin-container">
    <h3 class="admin-h3">Comments</h3>

    @foreach ($post->comments as $comment)
        <div>
            <p><strong>{{ $comment->name }}</strong> said:<br />
            {!! $comment->body !!}</p>
        </div>
    @endforeach
</div>

<div class="admin-container">
    <h3 class="admin-h3">Subscribe</h3>

    <form method="POST" action="{{ route('subscription.store') }}">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}" />
        
        <div class="mb-5">
            <label for="emailaddress" class="text-grey-darker text-sm font-bold mb-2 block">E-mailadres</label>
            <input type="text" name="emailaddress" id="emailaddress" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required value="{{ old('emailaddress') }}" />
            <p class="form-info">Wordt een URL van gemaakt en toont op de voorpagina</p>

            @if ($errors->has('emailaddress'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('emailaddress') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">Opslaan</button>
            <button type="reset" class="btn btn-grey">Reset</button>
        </div>
    </form>
</div>

<div class="admin-container">
    <h3 class="admin-h3">Comment</h3>

    <form method="POST" action="{{ route('comment.store') }}">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}" />

        <div class="mb-5">
            <label for="emailaddress" class="text-grey-darker text-sm font-bold mb-2 block">Email adres</label>
            <input type="email" name="emailaddress" id="emailaddress" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required value="{{ old('emailaddress') }}" />
            <p class="form-info">Wordt een URL van gemaakt en toont op de voorpagina</p>

            @if ($errors->has('emailaddress'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('emailaddress') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="name" class="text-grey-darker text-sm font-bold mb-2 block">Name</label>
            <input type="text" name="name" id="name" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required value="{{ old('name') }}" />
            <p class="form-info">Wordt een URL van gemaakt en toont op de voorpagina</p>

            @if ($errors->has('name'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('name') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="body" class="text-grey-darker text-sm font-bold mb-2 block">Comment</label>
            <textarea name="body" id="body" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required>{{ old('body') }}</textarea>
            <p class="form-info">Wordt een URL van gemaakt en toont op de voorpagina</p>

            @if ($errors->has('body'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('body') }}</span>
                </div>
            @endif
        </div>

        <div class="form-group">
            Notify: <input type="checkbox" name="notify" value="1" />
        </div>

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">Opslaan</button>
            <button type="reset" class="btn btn-grey">Reset</button>
        </div>
    </form>
</div>
@endsection