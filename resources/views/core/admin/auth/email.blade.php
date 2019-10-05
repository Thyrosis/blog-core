@extends ('core.layout.app')

@section ('title', __('Reset Password'))

@section ('main')

<div class="admin-container">
    <form method="POST" action="{{ route('password.email') }}" class="p-8">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">@lang('E-Mail Address')</label>

            <div>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="@lang('email@address.ex')" class="form-control">

                @if ($errors->has('email'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('email') }}</span>
                    </div>
                @endif
            </div>
        </div>

        
        <div class="form-button-group">
            <button type="submit" class="btn btn-purple" type="button">
                {{ __('Send Password Reset Link') }}
            </button>

            <a class="btn btn-text btn-orange-text" href="/admin">@lang('Login')</a>
        </div>
        
    </form>
</div>

@endsection