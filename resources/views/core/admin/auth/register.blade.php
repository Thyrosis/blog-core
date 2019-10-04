@extends ('core.layout.app')

@section ('title', __('Dashboard'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang("Register")</h3>

    <form method="POST" action="{{ route('register') }}" class="p-8">
        @csrf

         <div class="mb-4">
            <label for="name" class="form-label">@lang('Name')</label>

            <div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="@lang('Your Name')" class="form-control">

                @if ($errors->has('name'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('name') }}</span>
                    </div>
                @endif
            </div>
        </div>

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
            <label for="password-confirm" class="form-label">@lang('Confirm Password')</label>

            <div>
                <input id="password-confirm" type="password" name="password_confirmation" required class="form-control">

                @if ($errors->has('password_confirmation'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('password_confirmation') }}</span>
                    </div>
                @endif 
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div>
                <button type="submit" class="btn btn-green" type="button">
                    @lang('Register')
                </button>

                <a href="{{ route('login') }}" class="btn btn-text btn-orange-text">
                    @lang('Login')
                </a>
            </div>
        </div>
    </form>
</div>

@endsection