@extends ('core.layout.app')

@section ('title', $user->name )

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3 flex justify-between">
        {{ $user->email }}
        @if (auth()->id() == $user->id)
        <a href="{{ route('profile.edit', $user) }}" class="btn-blue-text">
            <i data-feather="edit-3"></i>
        </a>
        @endif
    </h3>

    <div class="profile">
        @foreach ($user->metas as $meta)
        <div class="form-group">
            <label class="form-label" for="{{ $meta->code }}">{{ $meta->label }}</label>
            <input class="form-control" id="{{ $meta->code }}" name="{{ $meta->code }}" type="text" value="{{ $user->meta($meta->code) }}" />
            <p class="form-info">{{ $meta->description }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection