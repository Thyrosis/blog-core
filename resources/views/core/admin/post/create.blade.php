@extends ('core.layout.app')

@section ('title')
    Posts
@endsection

@section ('main')

<form method="POST" action="{{ route('admin.post.store') }}" >
    {{ csrf_field() }}
    <div class="admin-container">
        <h3 class="admin-h3">Create new post</h3>

        <div class="mb-5">
            <label for="title" class="text-grey-darker text-sm font-bold mb-2 block">Titel</label>
            <input type="text" id="title" name="title" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" required value="{{ old('title') }}" />
            <p class="form-info">Wordt een URL van gemaakt en toont op de voorpagina</p>

            @if ($errors->has('title'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('title') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="longTitle" class="text-grey-darker text-sm font-bold mb-2 block">Lange Titel</label>
            <input type="text" id="longTitle" name="longTitle" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" value="{{ old('longTitle') }}" />
            <p class="form-info">De 'echte' titel van het artikel. Staat er boven.</p>

            @if ($errors->has('longTitle'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('longTitle') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="summary" class="text-grey-darker text-sm font-bold mb-2 block">Samenvatting</label>
            <textarea id="summary" name="summary" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" rows="5">{{ old('summary') }}</textarea>
            <p class="form-info">Wordt in het huidige template niet gebruikt, maar zou een beknopte samenvatting van het artikel moeten zijn.</p>

            @if ($errors->has('summary'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('summary') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="body" class="text-grey-darker text-sm font-bold mb-2 block">Artikel</label>
            <textarea id="body" name="body" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner tinymce" >{{ old('body') }}</textarea>
            <p class="form-info">De tekst van het artikel.</p>

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
                <label for="commentable" class="text-grey-darker text-sm font-bold mb-2 block">Reacties toestaan</label>
                <div class="flex">
                    <div class="my-1 mx-2"><input type="radio" name="commentable" value="0" @if ( old('commentable') == 0 ) checked @endif /> Nee</div>
                    <div class="my-1 mx-2"><input type="radio" name="commentable" value="1" @if ( old('commentable') == 1 ) checked @endif /> Ja</div>
                </div>
                <p class="form-info">Of lezers mogen reageren.</p>

                @if ($errors->has('commentable'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('commentable') }}</span>
                    </div>
                @endif
            </div>
                
            <div class="mb-5">
                <label for="published" class="text-grey-darker text-sm font-bold mb-2 block">Gepubliceerd</label>
                <div class="flex flex-wrap">
                    <div class="my-1 mx-2"><input type="radio" name="published" value="0" @if ( old('published') == 0 ) checked @endif /> Nee</div>
                    <div class="my-1 mx-2"><input type="radio" name="published" value="1" @if ( old('published') == 1 ) checked @endif /> Ja</div>
                </div>
                <p class="form-info">Mag het live?</p>

                @if ($errors->has('published'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('published') }}</span>
                    </div>
                @endif
            </div>

            <div class="mb-5">
                <label for="featured" class="text-grey-darker text-sm font-bold mb-2 block">Uitgelicht artikel</label>
                <div class="flex">            
                    <div class="my-1 mx-2"><input type="radio" name="featured" value="0" @if ( old('featured') == 0 ) checked @endif /> Nee</div>
                    <div class="my-1 mx-2"><input type="radio" name="featured" value="1" @if ( old('featured') == 1 ) checked @endif /> Ja</div>
                </div>
                <p class="form-info">Is het spectaculair?</p>

                @if ($errors->has('featured'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('featured') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-5">
            <label for="featureimage" class="text-grey-darker text-sm font-bold mb-2 block">Afbeelding (<a href="{{ config('custom.cdnUrl') }}" target="_blank">CDN</a>)</label>
            <input type="text" id="featureimage" name="featureimage" class="shadow w-full border rounded px-2 py-2  focus:shadow-inner" value="{{ old('featureimage') }}" />
            <p class="form-info">Minimale breedte afbeelding: 850px</p>

            @if ($errors->has('featureimage'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('featureimage') }}</span>
                </div>
            @endif
        </div>
    
        <div class="mb-5">
            <label for="categories" class="text-grey-darker text-sm font-bold mb-2 block">Categorie</label>
            <div class="flex  flex-wrap">
                @foreach (\App\Category::all() as $category)
                <div class="my-1 mx-2"><input type="checkbox" name="categories[]" value="{{ $category->id }}" @if (collect(old('categories'))->contains($category->id)) checked @endif /> {{ $category->name }}</div>
                @endforeach
            </div>
            <p class="form-info">De categorie waar de post in wordt ondergebracht.</p>

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
            <p class="form-info">De tags die aan het artikel worden gekoppeld.</p>

            @if ($errors->has('tags'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('tags') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5">
            <label for="published_at" class="text-grey-darker text-sm font-bold mb-2 block">Publicatiedatum</label>
            <input type="date" id="published_at" name="published_at" class="shadow w-full border rounded px-2 py-2 focus:shadow-inner" value="{{ old('published_at', \Carbon\Carbon::now()->toDateString()) }}" />
            <p class="form-info">Datum dat post verschijnt. Antidateren mag. Datum vandaag betekent direct live.</small>

            @if ($errors->has('published_at'))
                <div class="form-error">
                    <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('published_at') }}</span>
                </div>
            @endif
        </div>

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">Opslaan</button>
            <button type="reset" class="btn btn-grey">Reset</button>
        </div>
    </div>
</form>
@endsection