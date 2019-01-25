@extends ('core.layout.app')

@section ('title', 'Dashboard')

@section ('main')

<div class="admin-container">
    <form method="POST" action="{{ route('login') }}" class="p-8">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-grey-darker text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>

            <div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@address.ext" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline">

                @if ($errors->has('email'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('email') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-grey-darker text-sm font-bold mb-2">{{ __('Password') }}</label>

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
                            {{ __('Remember Me') }}
                        </span> 
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div>
                <button type="submit" class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                    {{ __('Login') }}
                </button>

                <a href="{{ route('password.request') }}" class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker">
                    {{ __('Forgot Your Password?') }}
                </a>
            </div>
        </div>
    </form>
</div>

@endsection