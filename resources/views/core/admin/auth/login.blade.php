@extends ('core.layout.app')

@section ('title', __('Login'))

@section ('main')

<div class="admin-container">
    
    <form method="POST" action="{{ route('login') }}" class="p-8">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">@lang('E-mail Address')</label>

            <div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="@lang('email@address.ex')" class="form-control">

                @if ($errors->has('email'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('email') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">@lang('Password')</label>

            <div>
                <input id="password" type="password" name="password" required class="form-control">

                @if ($errors->has('password'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('password') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-4">
            <div>
                <div>
                    <label class="form-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="mr-2 leading-tight">
                        <span class="text-sm">
                            @lang('Remember me')
                        </span> 
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div>
                <button type="submit" class="btn btn-purple" type="button">
                    @lang('Login')
                </button>

                <a href="{{ route('password.request') }}" class="ml-5 inline-block align-baseline btn-purple-text">
                    @lang('Forgot your password')
                </a>
            </div>

            @if (Setting::get('user.allowRegistrations'))
            <div>
                Nog geen account?
                <a class="inline-block align-baseline btn-purple-text" href="{{ route('register') }}">Registreren</a>
            </div>
            @endif
        </div>
    </form>
</div>

@endsection