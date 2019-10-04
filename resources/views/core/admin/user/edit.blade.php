@extends ('core.layout.app')

@section ('title', __('Users'))

@section ('main')

<div class="admin-container">
    <form method="POST" action="{{ route('admin.user.update', $user) }}">
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

        @foreach ($metas->where('updateable', true) as $meta)
            <div class="form-group">
                <label class="form-label" for="{{ $meta->code }}">{{ $meta->label }}</label>
                @if ($meta->code == 'access-level')
                    <select class="form-control" id="{{ $meta->code }}" name="{{ $meta->code }}">
                        <option value="user" @if ($user->meta($meta->code) == "user") selected @endif >@lang('User')</option>
                        <option value="moderator" @if ($user->meta($meta->code) == "moderator") selected @endif >@lang('Moderator')</option>
                        <option value="admin" @if ($user->meta($meta->code) == "admin") selected @endif >@lang('Admin')</option>
                    </select>
                @else
                    <input class="form-control" id="{{ $meta->code }}" name="{{ $meta->code }}" type="text" value="{{ $user->meta($meta->code) }}" />
                @endif
                <p class="form-info">{{ $meta->description }}</p>
            </div>
        @endforeach


        @foreach ($metas->where('updateable', false) as $meta)
            <div class="form-group">
                <label class="form-label" for="{{ $meta->code }}">{{ $meta->label }}</label>
                <input class="form-control" id="{{ $meta->code }}" name="{{ $meta->code }}" type="text" value="{{ $user->meta($meta->code) }}" disabled />
                <p class="form-info">{{ $meta->description }}</p>
            </div>
        @endforeach

        <div class="form-button-group">
            <button type="submit" class="btn btn-green">@lang('Update')</button>
            <button type="reset" class="btn btn-text btn-orange-text">@lang('Clear this form')</button>
        </div>
    </form>
</div>
@endsection