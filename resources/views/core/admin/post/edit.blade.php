@extends ('core.layout.app')

@section ('title', 'Posts')

@section ('main')

<form method="POST" action="{{ route('admin.post.update', $post) }}" >
    @csrf
    @method ('PATCH')

    <input type="hidden" id="user_id" name="user_id" value="{{ $post->user_id }}" />

    <div class="admin-container">
        <h3 class="admin-h3">Edit post</h3>

        <div class="mb-5 flex flex-wrap md:flex-no-wrap">
            <div class="mr-5 flex flex-col justify-around">
                <div class="mb-5">
                    <label for="title" class="text-grey-darker text-sm font-bold mb-2 block">Title</label>
                    <input type="text" id="title" name="title" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required value="{{ old('title', $post->title) }}" />
                    <p class="form-info">The title of the post. Will be turned into a URL-friendly slug too.</p>

                    @if ($errors->has('title'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('title') }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-5">
                    <label for="slug" class="text-grey-darker text-sm font-bold mb-2 block">Slug</label>
                    <input type="text" id="slug" name="slug" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required value="{{ old('slug', $post->slug) }}" />
                    <p class="form-info">URL-friendly version of the title. Needs to be unique.</p>

                    @if ($errors->has('slug'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('slug') }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-5">
                    <label for="longTitle" class="text-grey-darker text-sm font-bold mb-2 block">Long title</label>
                    <input type="text" id="longTitle" name="longTitle" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" value="{{ old('longTitle', $post->longTitle) }}" />
                    <p class="form-info">The 'real' title of the article. Doesn't serve any technical purpose but can be used in themes if one so wishes to do so.</p>

                    @if ($errors->has('longTitle'))
                        <div class="form-error">
                            <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('longTitle') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        
            <div class="mb-5">
                <label for="summary" class="text-grey-darker text-sm font-bold mb-2 block">Summary</label>
                <textarea id="summary" name="summary" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner tinymce-slim" rows="10">{{ old('summary', $post->summary) }}</textarea>
                <p class="form-info">A small summary of the post. Often used on index pages or search results.</p>

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
            <textarea id="body" name="body" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner tinymce-{{ config('custom.tinyMCEStyle')}}" rows="20">{{ old('body', $post->body) }}</textarea>
            <p class="form-info">The body of the post.</p>

            @if ($errors->has('body'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('body') }}</span>
                </div>
            @endif
        </div>
    </div>

    <div class="admin-container">
        <h3 class="admin-h3">Extra info</h3>

        <div class="flex justify-between">
            <div class="mb-5">
                <label for="commentable" class="text-grey-darker text-sm font-bold mb-2 block">Allow comments</label>
                <div class="flex">
                    <div class="my-1 mx-2"><input type="radio" name="commentable" value="0" @if ( old('commentable', $post->commentable) == 0 ) checked @endif /> No</div>
                    <div class="my-1 mx-2"><input type="radio" name="commentable" value="1" @if ( old('commentable', $post->commentable) == 1 ) checked @endif /> Yes</div>
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
                    <div class="my-1 mx-2"><input type="radio" name="published" value="0" @if ( old('published', $post->published) == 0 ) checked @endif /> Draft</div>
                    <div class="my-1 mx-2"><input type="radio" name="published" value="1" @if ( old('published', $post->published) == 1 ) checked @endif /> Published</div>
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
                    <div class="my-1 mx-2"><input type="radio" name="featured" value="0" @if ( old('featured', $post->featured) == 0 ) checked @endif /> Nee</div>
                    <div class="my-1 mx-2"><input type="radio" name="featured" value="1" @if ( old('featured', $post->featured) == 1 ) checked @endif /> Ja</div>
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
            <input type="text" id="featureimage" name="featureimage" class="shadow w-full border rounded px-2 py-2  focus:shadow-inner" value="{{ old('featureimage', $post->featureimage) }}" />
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
                <div class="my-1 mx-2"><input type="checkbox" name="categories[]" value="{{ $category->id }}" @if (collect(old('categories'))->contains($category->id) || $post->categories->pluck('id')->contains($category->id)) checked @endif /> {{ $category->name }}</div>
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
                <div class="my-1 mx-2"><input type="checkbox" name="tags[]" value="{{ $tag->id }}" @if (collect(old('tags'))->contains($tag->id) || $post->tags->pluck('id')->contains($tag->id)) checked @endif /> {{ $tag->name }}</div>
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
            <input type="date" id="published_at_date" name="published_at_date" class="shadow border rounded px-2 py-2 focus:shadow-inner" value="{{ old('published_at_date', $post->published_at->toDateString()) }}" />
            <input type="time" id="published_at_time" name="published_at_time" class="shadow border rounded px-2 py-2 focus:shadow-inner" value="{{ old('published_at_time', $post->published_at->format('H:i')) }}" />

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
            <button type="submit" class="btn btn-blue">Update</button>
            <button type="reset" class="btn btn-grey">Reset</button>
        </div>
    </div>
</form>

<form method="POST" action="{{ route('admin.post.destroy', $post) }}" >
    @csrf
    @method ('DELETE')

    <div class="admin-container">
        <h3 class="admin-h3">Delete post</h3>

        <p>
            If you use this button, you will completely delete a post from all records. It will vanish into the nothingness that is called void. It can NOT be undone! If there is even the slightest chance you will want to keep whatever you've written, just unpublish it.
        </p>

        <div class="mb-5">
            <button type="submit" class="btn btn-red" onclick="return confirm('Are you really, absolutely, one hunderd percent sure you want to delete this post? It cannot be undone!');">Delete</button>
        </div>
    </div>    
</form>
@endsection
