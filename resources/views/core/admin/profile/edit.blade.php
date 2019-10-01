@extends ('core.layout.app')

@section ('title', __('Users'))

@section ('main')

<div class="admin-container">
    <form method="POST" action="{{ route('profile.update', $user) }}">
        @csrf
        @method ("PATCH")
        <div class="form-group">
            <label class="form-label" for="name">@lang('Name')</label>
            <input class="form-control" id="name" name="name" type="text" value="{{ $user->name }}" />
            <p class="form-info">@lang('Chosen username. Used to identify the user to others, not for logging in.')</p>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">@lang('E-mail Address')</label>
            <input class="form-control" id="email" name="email" type="email" value="{{ $user->email }}" />
            <p class="form-info">@lang('User\'s email address. Used for logging in and sending messages.')</p>
        </div>

        <div class="form-group">
            <label class="form-label" for="api_token">@lang('API token')</label>
            <input class="form-control" id="api_token" name="api_token" type="text" value="" />
            <p class="form-info">@lang('User\'s api_token. Used for logging in via the API. Only enter something here if you want to CHANGE your current token.')</p>
        </div>

        @foreach (App\Meta::where('updateable', true)->get() as $meta)
            @if ($meta->code !== "access-level")
            <div class="form-group">
                <label class="form-label" for="{{ $meta->code }}">{{ $meta->label }}</label>
                <input class="form-control" id="{{ $meta->code }}" name="{{ $meta->code }}" type="text" value="{{ $user->meta($meta->code) }}" />
                <p class="form-info">{{ $meta->description }}</p>
            </div>
            @endif
        @endforeach

        <div class="form-group">
            <button type="submit" class="btn btn-blue">@lang('Update')</button>
        </div>
    </form>
</div>
@endsection