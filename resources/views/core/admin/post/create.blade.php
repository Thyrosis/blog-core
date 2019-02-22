@extends ('core.layout.app')

@section ('title', __('Posts'))
    
@section ('main')

<form method="POST" action="{{ route('admin.post.store') }}" >
    {{ csrf_field() }}
    <div class="admin-container">
        <h3 class="admin-h3">@lang('Create new post')</h3>

        <div class="mb-5 flex flex-wrap md:flex-no-wrap">
            <div class="mr-5 flex flex-col justify-around">
                <div class="mb-5">
                    <label for="title" class="form-label">@lang('Title')</label>
                    <input type="text" id="title" name="title" class="form-control" required value="{{ old('title') }}" placeholder="@lang('Title')" />
                    <p class="form-info">@lang('The title of the post. Will be turned into a URL-friendly slug too.')</p>

                    @if ($errors->has('title'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('title') }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-5">
                    <label for="longTitle" class="form-label">@lang('Long title')</label>
                    <input type="text" id="longTitle" name="longTitle" class="form-control" value="{{ old('longTitle') }}" placeholder="Longer, more descriptive title" />
                    <p class="form-info">@lang('The \'real\' title of the article. Doesn\'t serve any technical purpose but can be used in themes if one so wishes to do so.')</p>

                    @if ($errors->has('longTitle'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('longTitle') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <label for="summary" class="form-label">@lang('Summary')</label>
                <textarea id="summary" name="summary" class="form-control tinymce-full" rows="10">{{ old('summary') }}</textarea>
                <p class="form-info">@lang('A small summary of the post. Often used on index pages.')</p>

                @if ($errors->has('summary'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('summary') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="admin-container">
        <h3 class="admin-h3">@lang('Content')</h3>

        <div class="mb-5">
            <label for="body" class="form-label">@lang('Body')</label>
            <textarea id="body" name="body" class="form-control tinymce-full" rows="20">{{ old('body') }}</textarea>
            <p class="form-info">@lang('The body of the post.')</p>

            @if ($errors->has('body'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('body') }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="admin-container">
        <h3 class="admin-h3">@lang('Extra information')</h3>

        <div class="flex justify-between">
            <div class="mb-5">
                <label for="commentable" class="form-label">@lang('Allow comments')</label>
                <div class="flex">
                    <div class="my-1 mx-2"><input type="radio" name="commentable" value="0" @if ( old('commentable', Setting::get('post.commentable')) == 0 ) checked @endif /> @lang('No')</div>
                    <div class="my-1 mx-2"><input type="radio" name="commentable" value="1" @if ( old('commentable', Setting::get('post.commentable')) == 1 ) checked @endif /> @lang('Yes')</div>
                </div>
                <p class="form-info">@lang('Can be used to show or hide comment fields on the front end.')</p>

                @if ($errors->has('commentable'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('commentable') }}</span>
                    </div>
                @endif
            </div>
                
            <div class="mb-5">
                <label for="published" class="form-label">@lang('Published status')</label>
                <div class="flex flex-wrap">
                    <div class="my-1 mx-2"><input type="radio" name="published" value="0" @if ( old('published', Setting::get('post.published')) == 0 ) checked @endif /> @lang('Draft')</div>
                    <div class="my-1 mx-2"><input type="radio" name="published" value="1" @if ( old('published', Setting::get('post.published')) == 1 ) checked @endif /> @lang('Published')</div>
                </div>
                <p class="form-info">@lang('Whether the post is included in \'published\' collections.')</p>

                @if ($errors->has('published'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('published') }}</span>
                    </div>
                @endif
            </div>

            <div class="mb-5">
                <label for="featured" class="form-label">@lang('Featured post')</label>
                <div class="flex">            
                    <div class="my-1 mx-2"><input type="radio" name="featured" value="0" @if ( old('featured') == 0 ) checked @endif /> @lang('No')</div>
                    <div class="my-1 mx-2"><input type="radio" name="featured" value="1" @if ( old('featured') == 1 ) checked @endif /> @lang('Yes')</div>
                </div>
                <p class="form-info">@lang('Featured posts can for instance be highlighted in the theme or pinned to the top of the page.')</p>

                @if ($errors->has('featured'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('featured') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-5">
            <label for="featureimage" class="form-label">@lang('Feature Image') (<a href="{{ Setting::get('cdn.url') }}" target="_blank">CDN</a>)</label>
            <input class="form-control" id="featureimage" name="featureimage" type="text" value="{{ old('featureimage', Setting::get('post.defaultFeatureImage')) }}" />
            <p class="form-info">@lang('Doesn\'t serve a technical purpose, but can be used in themes.')</p>

            @if ($errors->has('featureimage'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('featureimage') }}</span>
                </div>
            @endif
        </div>
    
        <div class="mb-5">
            <label for="categories" class="form-label">@lang('Category')</label>
            <div class="flex  flex-wrap">
                @foreach (\App\Category::all() as $category)
                <div class="my-1 mx-2"><input type="checkbox" name="categories[]" value="{{ $category->id }}" @if (collect(old('categories'))->contains($category->id)) checked @endif /> {{ $category->name }}</div>
                @endforeach
            </div>
            <p class="form-info">@lang('The category to which this post is linked. Can use multiple if needed, but you should probably use tags for that.')</p>

            @if ($errors->has('categories'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('categories') }}</span>
                </div>
            @endif
        </div>
            
        <div class="mb-5">
            <label for="tags" class="form-label">@lang('Tags')</label>
            <div class="flex flex-wrap">
                @foreach (\App\Tag::all() as $tag)
                <div class="my-1 mx-2"><input type="checkbox" name="tags[]" value="{{ $tag->id }}" @if (collect(old('tags'))->contains($tag->id)) checked @endif /> {{ $tag->name }}</div>
                @endforeach
            </div>
            <p class="form-info">@lang('The tags to which this post is linked. You could use just one, but you should probably use a category for that.')</p>

            @if ($errors->has('tags'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('tags') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="published_at" class="form-label">@lang('Publish date and time')</label>
            <input type="date" id="published_at_date" name="published_at_date" class="form-control w-1/5" value="{{ old('published_at_date', \Carbon\Carbon::now()->toDateString()) }}" />
            <input type="time" id="published_at_time" name="published_at_time" class="form-control w-1/5" value="{{ old('published_at_time', \Carbon\Carbon::now()->format('H:i')) }}" />
            <p class="form-info">@lang('Publishing date and time. A date in the past with status set to published means the post will be published immediately.') @lang('Current time'): {{ \Carbon\Carbon::now()->format('H:i') }}</p>

            @if ($errors->has('published_at_date'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('published_at') }}</span>
                </div>
            @endif

            @if ($errors->has('published_at_time'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('published_at_time') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">@lang('Create')</button>
            <button type="reset" class="btn btn-grey">@lang('Reset')</button>
        </div>
    </div>
</form>
@endsection