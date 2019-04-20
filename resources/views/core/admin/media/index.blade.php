@extends ('core.layout.app')

@section ('title', __('Media'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang('New Media')</h3>
    <p>
        <a href="{{ route('admin.post.create') }}" class="btn btn-teal">
            @lang('Create')
        </a>
    </p>
</div>

<div class="admin-container">
    <h3 class="admin-h3">@lang('Media')</h3>

    @foreach ($medias as $media)
        <img src="{{ $media->filepath }}" alt="{{ $media->label ?? '' }} - {{ $media->description ?? '' }}" />
    @endforeach
</div>

@endsection