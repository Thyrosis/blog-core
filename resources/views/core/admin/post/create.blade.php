@extends ('core.layout.app')

@section ('title')
    Posts
@endsection

@section ('main')

<form method="POST" action="{{ route('admin.post.store') }}" >
    {{ csrf_field() }}
    <div class="admin-container">
        <h3 class="admin-h3">Create new post</h3>

        <div class="mb-5 flex flex-wrap md:flex-no-wrap">
            <div class="mr-5 flex flex-col justify-around">
                <div class="mb-5">
                    <label for="title" class="text-grey-darker text-sm font-bold mb-2 block">Title</label>
                    <input type="text" id="title" name="title" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required value="{{ old('title') }}" placeholder="Title" />
                    <p class="form-info">The title of the post. Will be turned into a URL-friendly slug too.</p>

                    @if ($errors->has('title'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('title') }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-5">
                    <label for="longTitle" class="text-grey-darker text-sm font-bold mb-2 block">Long title</label>
                    <input type="text" id="longTitle" name="longTitle" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" value="{{ old('longTitle') }}" placeholder="Longer, more descriptive title" />
                    <p class="form-info">The 'real' title of the article. Doesn't serve any technical purpose but can be used in themes if one so wishes to do so.</p>

                    @if ($errors->has('longTitle'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('longTitle') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <label for="summary" class="text-grey-darker text-sm font-bold mb-2 block">Summary</label>
                <textarea id="summary" name="summary" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner tinymce-slim" rows="10">{{ old('summary') }}</textarea>
                <p class="form-info">A small summary of the post. Often used on index pages.</p>

                @if ($errors->has('summary'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('summary') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="admin-container">
        <h3 class="admin-h3">Content</h3>

        <div class="mb-5">
            <label for="body" class="text-grey-darker text-sm font-bold mb-2 block">Body</label>
            <textarea id="body" name="body" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner tinymce" rows="20">{{ old('body') }}</textarea>
            <p class="form-info">The body of the post.</p>

            @if ($errors->has('body'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('body') }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="admin-container">
        <h3 class="admin-h3">Extra information</h3>

        <div class="flex justify-between">
            <div class="mb-5">
                <label for="commentable" class="text-grey-darker text-sm font-bold mb-2 block">Allow comments</label>
                <div class="flex">
                    <div class="my-1 mx-2"><input type="radio" name="commentable" value="0" @if ( old('commentable', config('custom.defaultCommentable')) == 0 ) checked @endif /> No</div>
                    <div class="my-1 mx-2"><input type="radio" name="commentable" value="1" @if ( old('commentable', config('custom.defaultCommentable')) == 1 ) checked @endif /> Yes</div>
                </div>
                <p class="form-info">Can be used to show or hide comment fields on the front end.</p>

                @if ($errors->has('commentable'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('commentable') }}</span>
                    </div>
                @endif
            </div>
                
            <div class="mb-5">
                <label for="published" class="text-grey-darker text-sm font-bold mb-2 block">Published status</label>
                <div class="flex flex-wrap">
                    <div class="my-1 mx-2"><input type="radio" name="published" value="0" @if ( old('published', config('custom.defaultPublished')) == 0 ) checked @endif /> Draft</div>
                    <div class="my-1 mx-2"><input type="radio" name="published" value="1" @if ( old('published', config('custom.defaultPublished')) == 1 ) checked @endif /> Published</div>
                </div>
                <p class="form-info">Whether the post is included in 'published' collections.</p>

                @if ($errors->has('published'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('published') }}</span>
                    </div>
                @endif
            </div>

            <div class="mb-5">
                <label for="featured" class="text-grey-darker text-sm font-bold mb-2 block">Featured post</label>
                <div class="flex">            
                    <div class="my-1 mx-2"><input type="radio" name="featured" value="0" @if ( old('featured') == 0 ) checked @endif /> No</div>
                    <div class="my-1 mx-2"><input type="radio" name="featured" value="1" @if ( old('featured') == 1 ) checked @endif /> Yes</div>
                </div>
                <p class="form-info">Featured posts can for instance be highlighted in the theme or pinned to the top of the page.</p>

                @if ($errors->has('featured'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('featured') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-5">
            <label for="featureimage" class="text-grey-darker text-sm font-bold mb-2 block">Feature Image (<a href="{{ config('custom.cdnUrl') }}" target="_blank">CDN</a>)</label>
            <input type="text" id="featureimage" name="featureimage" class="shadow w-full border rounded px-2 py-2  focus:shadow-inner" value="{{ old('featureimage') }}" />
            <p class="form-info">Doesn't serve a technical purpose, but can be used in themes.</p>

            @if ($errors->has('featureimage'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('featureimage') }}</span>
                </div>
            @endif
        </div>
    
        <div class="mb-5">
            <label for="categories" class="text-grey-darker text-sm font-bold mb-2 block">Category</label>
            <div class="flex  flex-wrap">
                @foreach (\App\Category::all() as $category)
                <div class="my-1 mx-2"><input type="checkbox" name="categories[]" value="{{ $category->id }}" @if (collect(old('categories'))->contains($category->id)) checked @endif /> {{ $category->name }}</div>
                @endforeach
            </div>
            <p class="form-info">The category to which this post is linked. Can use multiple if needed, but you should probably use tags for that.</p>

            @if ($errors->has('categories'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('categories') }}</span>
                </div>
            @endif
        </div>
            
        <div class="mb-5">
            <label for="tags" class="text-grey-darker text-sm font-bold mb-2 block">Tags</label>
            <div class="flex flex-wrap">
                @foreach (\App\Tag::all() as $tag)
                <div class="my-1 mx-2"><input type="checkbox" name="tags[]" value="{{ $tag->id }}" @if (collect(old('tags'))->contains($tag->id)) checked @endif /> {{ $tag->name }}</div>
                @endforeach
            </div>
            <p class="form-info">The tags to which this post is linked. You could use just one, but you should probably use a category for that.</p>

            @if ($errors->has('tags'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('tags') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="published_at" class="text-grey-darker text-sm font-bold mb-2 block">Publish date and time</label>
            <input type="date" id="published_at_date" name="published_at_date" class="shadow border rounded px-2 py-2 focus:shadow-inner" value="{{ old('published_at_date', \Carbon\Carbon::now()->toDateString()) }}" />
            <input type="time" id="published_at_time" name="published_at_time" class="shadow border rounded px-2 py-2 focus:shadow-inner" value="{{ old('published_at_time', \Carbon\Carbon::now()->format('H:i')) }}" />
            <p class="form-info">Publishing date and time. A date in the past with status set to published means the post will be published immediately. Current time: {{ \Carbon\Carbon::now()->format('H:i') }}</small>

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
            <button type="submit" class="btn btn-blue">Create</button>
            <button type="reset" class="btn btn-grey">Reset</button>
        </div>
    </div>
</form>
@endsection