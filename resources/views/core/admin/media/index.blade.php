@extends ('core.layout.app')

@section ('title', __('Media'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang('New Media')</h3>
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group">
                <label class="form-label" for="uploadedFiles">Bestanden selecteren</label>
                <input type="file" class="form-control" name="uploadedFiles[]" multiple aria-describedby="filesHelp" />
                <small id="filesHelp" class="form-text text-muted">De bestanden die je wilt uploaden.</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="category">Categorie</label>
                <input type="text" class="form-control" name="category" aria-describedby="categoryHelp" list="categories" />
                <datalist id="categories">
                    @foreach ($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </datalist>
                <small id="categoryHelp" class="form-text text-muted">De categorie waaraan je deze foto's wil toevoegen.</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="label">Label</label>
                <input type="text" class="form-control" name="label" aria-describedby="labelHelp" />
                <small id="labelHelp" class="form-text text-muted">Een label</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Omschrijving</label>
                <textarea class="form-control" name="description" aria-describedby="descriptionHelp"></textarea>
                <small id="descriptionHelp" class="form-text text-muted">Een omschrijving</small>
            </div>

            <div class="form-button-group">
                <button type="submit" class="btn btn-green">@lang('Upload')</button>
                <button type="reset" class="btn btn-text btn-orange-text">@lang('Clear this form')</button>
            </div>  
        </form>
</div>

<div class="admin-container">
    <h3 class="admin-h3">@lang('Media')</h3>

    @foreach ($medias as $media)
        <img alt="{{ $media->label ?? '' }} - {{ $media->description ?? '' }}" src="{{ $media->path() }}" title="{{ $media->label ?? '' }} - {{ $media->description ?? '' }}" />
    @endforeach
</div>

@endsection