@extends ('core.layout.app')

@section ('title')
    {{ __('Reset Password') }}
@endsection

@section ('main')

<div class="admin-container">
    <form method="POST" action="{{ route('password.email') }}" class="p-8">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-grey-darker text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>

            <div>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="email@address.ext" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline">

                @if ($errors->has('email'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('email') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div>
                <button type="submit" class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </div>
    </form>
</div>

@endsection