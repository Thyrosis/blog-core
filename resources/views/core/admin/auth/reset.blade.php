@extends ('core.layout.app')

@section ('title', __('Dashboard'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang("Reset Password")</h3>

    <form method="POST" action="{{ route('password.request') }}" class="p-8">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-4">
            <label for="email" class="block text-grey-darker text-sm font-bold mb-2">@lang('E-mail Address')</label>

            <div>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="@lang('email@address.ex')" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline">

                @if ($errors->has('email'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('email') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-grey-darker text-sm font-bold mb-2">@lang('Password')</label>

            <div>
                <input id="password" type="password" name="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline">

                @if ($errors->has('password'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('password') }}</span>
                    </div>
                @endif  
            </div>
        </div>

        <div class="mb-4">
            <label for="password-confirm" class="block text-grey-darker text-sm font-bold mb-2">@lang('Confirm Password')</label>

            <div>
                <input id="password-confirm" type="password" name="password_confirmation" required class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline">

                @if ($errors->has('password_confirmation'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('password_confirmation') }}</span>
                    </div>
                @endif 
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div>
                <button type="submit" class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                    @lang('Reset Password')
                </button>
            </div>
        </div>
    </form>
</div>

@endsection