@extends ('core.layout.app')

@section ('title', __('Posts'))

@section ('main')

<form method="POST" action="{{ route('admin.post.update', $post) }}" >
    @csrf
    @method ('PATCH')

    <input type="hidden" id="user_id" name="user_id" value="{{ $post->user_id }}" />

    <div class="admin-container">
        <h3 class="admin-h3 flex justify-between">
            @lang('Edit post')
            <a href="{{ route('post.show', $post) }}" target="_blank" class="no-underline">
                <i class="text-grey-darkest" class="text-teal" data-feather="eye"></i>
            </a>
        </h3>

        <div class="mb-5 flex flex-wrap md:flex-no-wrap">
            <div class="mr-5 flex flex-col justify-around">
                <div class="mb-5">
                <label for="title" class="form-label">@lang('Title')</label>
                    <input type="text" id="title" name="title" class="form-control" required value="{{ old('title', $post->title) }}" />
                    <p class="form-info">@lang('The title of the post. Will be turned into a URL-friendly slug too.')</p>

                    @if ($errors->has('title'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('title') }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-5">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" required value="{{ old('slug', $post->slug) }}" />
                    <p class="form-info">URL-friendly version of the title. Needs to be unique.</p>

                    @if ($errors->has('slug'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('slug') }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-5">
                    <label for="longTitle" class="form-label">@lang('Long title')</label>
                    <input type="text" id="longTitle" name="longTitle" class="form-control" value="{{ old('longTitle', $post->longTitle) }}" />
                    <p class="form-info">@lang('The \'real\' title of the article. Doesn\'t serve any technical purpose but can be used in themes if one so wishes to do so.')</p>

                    @if ($errors->has('longTitle'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('longTitle') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        
            <div class="mb-5">
                <label for="summary" class="form-label">@lang('Summary')</label>
                <textarea id="summary" name="summary" class="form-control tinymce-full" rows="10">{{ old('summary', $post->summary) }}</textarea>
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
            <textarea id="body" name="body" class="form-control tinymce-full" rows="20">{{ old('body', $post->body()) }}</textarea>
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

        <div class="flex justify-between flex-col md:flex-row">
            <div class="mb-5">
                <label for="commentable" class="form-label">@lang('Allow comments')</label>
                <div class="flex">
                    <div class="my-1 mx-2"><input type="radio" name="commentable" value="0" @if ( old('commentable', $post->commentable) == 0 ) checked @endif /> No</div>
                    <div class="my-1 mx-2"><input type="radio" name="commentable" value="1" @if ( old('commentable', $post->commentable) == 1 ) checked @endif /> Yes</div>
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
                    <div class="my-1 mx-2"><input type="radio" name="published" value="0" @if ( old('published', $post->published) == 0 ) checked @endif /> @lang('Draft')</div>
                    <div class="my-1 mx-2"><input type="radio" name="published" value="1" @if ( old('published', $post->published) == 1 ) checked @endif /> @lang('Published')</div>
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
                    <div class="my-1 mx-2"><input type="radio" name="featured" value="0" @if ( old('featured', $post->featured) == 0 ) checked @endif /> @lang('No')</div>
                    <div class="my-1 mx-2"><input type="radio" name="featured" value="1" @if ( old('featured', $post->featured) == 1 ) checked @endif /> @lang('Yes')</div>
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
            <input type="text" id="featureimage" name="featureimage" class="form-control" value="{{ old('featureimage', $post->featureimage) }}" />
            <p class="form-info">@lang('Doesn\'t serve a technical purpose, but can be used in themes.')</p>

            @if ($errors->has('featureimage'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('featureimage') }}</span>
                </div>
            @endif
        </div>
    
        <div class="flex justify-between flex-col md:flex-row">
            @php
                $categories = \App\Category::all()
            @endphp

            @if ($categories->count() > 0)
                <div class="mb-5 md:w-1/2 md:mr-1">
                    <label for="categories" class="form-label">@lang('Category')</label>
                    <div class="flex  flex-wrap">
                        @foreach (\App\Category::all() as $category)
                        <div class="my-1 mx-2"><input type="checkbox" name="categories[]" value="{{ $category->id }}" @if (collect(old('categories'))->contains($category->id) || $post->categories->pluck('id')->contains($category->id)) checked @endif /> {{ $category->name }}</div>
                        @endforeach
                    </div>
                    <p class="form-info">@lang('The category to which this post is linked. Can use multiple if needed, but you should probably use tags for that.')</p>

                    @if ($errors->has('categories'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('categories') }}</span>
                        </div>
                    @endif
                </div>
            @endif
            
            @php
                $tags = \App\Tag::all()
            @endphp

            @if ($tags->count() > 0)   
                <div class="mb-5 md:w-1/2 md:ml-1">
                    <label for="tags" class="form-label">@lang('Tags')</label>
                    <div class="flex flex-wrap">
                        @foreach (\App\Tag::all() as $tag)
                        <div class="my-1 mx-2"><input type="checkbox" name="tags[]" value="{{ $tag->id }}" @if (collect(old('tags'))->contains($tag->id) || $post->tags->pluck('id')->contains($tag->id)) checked @endif /> {{ $tag->name }}</div>
                        @endforeach
                    </div>
                    <p class="form-info">@lang('The tags to which this post is linked. You could use just one, but you should probably use a category for that.')</p>

                    @if ($errors->has('tags'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('tags') }}</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex justify-between flex-col md:flex-row">
            <div class="mb-5 md:mr-1">
                <label for="type" class="form-label">@lang('Post type')</label>
                <select class="form-control" id="type" name="type">
                    <option value="post" @if (old('type', $post->type) == 'post') selected @endif >@lang('Post')</option>
                    <option value="page" @if (old('type', $post->type) == 'page') selected @endif >@lang('Page')</option>
                </select>
                <p class="form-info">@lang('Whether this is a post or a page.')</p>

                @if ($errors->has('type'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('type') }}</span>
                    </div>
                @endif
            </div>

            <div class="mb-5 md:w-1/2 md:ml-1">
                <label for="published_at" class="form-label">@lang('Publish date and time')</label>
                <input type="date" id="published_at_date" name="published_at_date" class="form-control w-1/5" value="{{ old('published_at_date', $post->published_at->toDateString()) }}" />
                <input type="time" id="published_at_time" name="published_at_time" class="form-control w-1/5" value="{{ old('published_at_time', $post->published_at->format('H:i')) }}" />

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
        </div>

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">@lang('Update')</button>
            <button type="reset" class="btn btn-grey">@lang('Reset')</button>
        </div>
    </div>
</form>

<form method="POST" action="{{ route('admin.post.destroy', $post) }}" >
    @csrf
    @method ('DELETE')

    <div class="admin-container">
        <h3 class="admin-h3">@lang('Delete post')</h3>

        <p>
            @lang('If you use this button, you will completely delete a post from all records. It will vanish into the nothingness that is called void. It can NOT be undone! If there is even the slightest chance you will want to keep whatever you\'ve written, just unpublish it.')
        </p>

        <div class="mb-5">
            <button type="submit" class="btn btn-red" onclick="return confirm('Are you really, absolutely, one hunderd percent sure you want to delete this post? It cannot be undone!');">@lang('Delete')</button>
        </div>
    </div>    
</form>
@endsection
