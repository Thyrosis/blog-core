@extends ('core.layout.app')

@section ('html.head')
<script type="application/ld+json">
    {
		"@context":"http://schema.org",
		"@type": "BlogPosting",
		"image": "{{ $post->getFeatureImage() }}",
		"url": "{{ $post->url() }}",
		"headline": "{{ $post->title }}",
		"alternativeHeadline": "{{ $post->longTitle }}",
		"dateCreated": "{{ $post->created_at->toIso8601String() }}",
		"datePublished": "{{ $post->published_at->toIso8601String() }}",
		"dateModified": "{{ $post->updated_at->toIso8601String() }}",
		"inLanguage": "en-GB",
		"isFamilyFriendly": "true",
		"copyrightYear": "{{ $post->published_at->year }}",
		"copyrightHolder": "",
		"contentLocation": {
			"@type": "Place",
			"name": "Eindhoven, Netherlands"
		},
		"accountablePerson": {
			"@type": "Person",
			"name": "{{ $post->user->name }}",
			"url": "{{ config('app.url') }}"
		},
		"author": {
			"@type": "Person",
			"name": "{{ $post->user->name }}",
			"url": "{{ config('app.url') }}"
		},
		"creator": {
			"@type": "Person",
			"name": "{{ $post->user->name }}",
			"url": "{{ config('app.url') }}"
		},
		"publisher": {
			"@type": "Organization",
			"name": "{{ config('app.name') }}",
			"url": "{{ config('app.url') }}"
		},
		"mainEntityOfPage": "True",
        @if (count($post->getKeywords('array')) > 0)
		"keywords": [
            @foreach ($post->getKeywords('array') as $keyword) "{{ $keyword }}" @if (!$loop->last),@endif 
            @endforeach
		],
        @endif
        @if ($post->categories->count() > 0)
		    "articleSection": "{{ $post->categories->first()->name }}",
        @endif
		"articleBody": "{!! str_replace('"', '\"', strip_tags($post->body)) !!}"
	}
</script>
@endsection

@section ('main')

<div class="admin-container">
    {!! App\Menu::toHTML(['ulID' => 'navigation', 'ulClass' => 'nav-ul', 'liClass' => 'nav-li', 'aClass' => 'nav-a']) !!}
</div>

<div class="admin-container">
    <h3 class="admin-h3">{{ $post->title }}</h3>

    <h4>{{ $post->user->name ?? config('app.defaultAuthor') }} @ {{ $post->published_at }}</h4>

    <div>
        {!! $post->body !!}
    </div>

    <!-- Leave this here to clear a possible image floating in the body -->
    <div style="clear: both">
    </div>
    <!-- Leave this here to clear a possible image floating in the body -->
    
    <p>Took you about {{ $post->readTime() }} {{ \Illuminate\Support\Str::plural('minute', $post->readTime()) }} to read, right?</p>
</div>

<div class="admin-container">
    <h3 class="admin-h3">@lang('Comments')</h3>

    @foreach ($post->approvedComments() as $comment)
        <div>
            <p><strong>{{ $comment->name }}</strong> @lang('said'):<br />
            {!! $comment->body !!}</p>
        </div>
    @endforeach
</div>

<div class="admin-container">
    <h3 class="admin-h3">@lang('Subscribe')</h3>

    <form method="POST" action="{{ route('subscription.store') }}">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}" />
        
        <div class="mb-5">
            <label class="form-label" for="emailaddress" >@lang('E-mail Address')</label>
            <input class="form-control" id="emailaddress" name="emailaddress" required type="text" value="{{ old('emailaddress') }}" />
            <p class="form-info">@lang('Your e-mail address. We\'ll only use it to send you a message when someone replies to this post.')</p>

            @if ($errors->has('emailaddress'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('emailaddress') }}</span>
                </div>
            @endif
        </div>

        <div class="form-button-group">
            <button type="submit" class="btn btn-green">@lang('Save')</button>
            <button type="reset" class="btn btn-text btn-orange-text">@lang('Reset')</button>
        </div>
    </form>
</div>

<div class="admin-container">
    <h3 class="admin-h3">@lang('Comment')</h3>

    <form method="POST" action="{{ route('comment.store') }}">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}" />

        <div class="mb-5">
            <label class="form-label" for="emailaddress">@lang('E-mail Address')</label>
            <input class="form-control" id="emailaddress" name="emailaddress" required type="email" value="{{ old('emailaddress') }}" />
            <p class="form-info">@lang('Your e-mail address. We\'ll only use it to send you a message when someone replies to this post.')</p>

            @if ($errors->has('emailaddress'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('emailaddress') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label class="form-label" for="name" >@lang('Name')</label>
            <input class="form-control" id="name" name="name" required type="text" value="{{ old('name') }}" />
            <p class="form-info">@lang('Your name. Will be published with your comment.')</p>

            @if ($errors->has('name'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('name') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label class="form-label" for="body">@lang('Comment')</label>
            <textarea class="form-control" id="body" name="body" required>{{ old('body') }}</textarea>
            <p class="form-info">@lang('Your comment')</p>

            @if ($errors->has('body'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('body') }}</span>
                </div>
            @endif
        </div>

        <div class="form-group">
            @lang('Subscribe'): <input type="checkbox" name="notify" value="1" />
        </div>

        <div class="form-button-group">
            <button type="submit" class="btn btn-green">@lang('Save')</button>
            <button type="reset" class="btn btn-text btn-orange-text">@lang('Clear this form')</button>
        </div>
    </form>
</div>
@endsection