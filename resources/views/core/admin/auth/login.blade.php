@extends ('core.layout.app')

@section ('title', __('Dashboard'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang("Login")</h3>
    
    <form method="POST" action="{{ route('login') }}" class="p-8">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-grey-darker text-sm font-bold mb-2">@lang('E-mail Address')</label>

            <div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="@lang('email@address.ex')" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline">

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
            <div>
                <div>
                    <label class="block text-grey font-bold">
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
                <button type="submit" class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                    @lang('Login')
                </button>

                <a href="{{ route('password.request') }}" class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker">
                    @lang('Forgot your password')
                </a>
            </div>

            @if (Setting::get('user.allowRegistrations'))
            <div>
                Nog geen account?
                <a class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker" href="{{ route('register') }}">Registreren</a>
            </div>
            @endif
        </div>
    </form>
</div>

@endsection