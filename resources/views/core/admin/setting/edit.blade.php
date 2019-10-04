@extends ('core.layout.app')

@section ('title', __('Settings'))

@section ('main')

<form method="POST" action="{{ route('admin.setting.update') }}">
    @csrf
    @method('PATCH')

    <div class="admin-container">
        @foreach ($settings as $setting)
        <div class="form-group">
            <label class="form-label" for="{{ $setting->code }}">{{ $setting->label }}</label>
            @if ($setting->type == "ARRAY")
            <textarea class="form-control" id="{{ $setting->code }}" name="{{ $setting->code }}">{{ $setting->getEditValue() }}</textarea>
            @elseif ($setting->type == "BOOLEAN")
            <select class="form-control" id="{{ $setting->code }}" name="{{ $setting->code }}">
                <option value="0" @if ($setting->value == "0") selected @endif >@lang('No')</option>
                <option value="1" @if ($setting->value == "1") selected @endif >@lang('Yes')</option>
            </select>
            @elseif ($setting->type == "TEXT") 
            <input class="form-control" id="{{ $setting->code }}" name="{{ $setting->code }}" type="text" value="{{ $setting->value }}" />
            @elseif ($setting->type == "NUMBER")
            <input class="form-control" id="{{ $setting->code }}" name="{{ $setting->code }}" type="number" value="{{ $setting->value }}" />
            @elseif ($setting->type == "TEXTAREA")
            <textarea class="form-control" id="{{ $setting->code }}" name="{{ $setting->code }}">{{ $setting->value }}</textarea>
            @endif
            <p class="form-info">{{ $setting->description }}</p>        
        </div>
        @endforeach

        @php 
            $setting = Setting::whereCode('home.url')->firstOrFail();
        @endphp
        <div class="form-group">
            <label class="form-label" for="{{ $setting->code }}">{{ $setting->label }}</label>
            <select class="form-control" id="{{ $setting->code }}" name="{{ $setting->code }}">
                <option value="">Indexpagina van artikelen</option>
                <option disabled> -- @lang('Posts') -- </option>
                @foreach (App\Post::orderBy('longTitle', 'ASC')->get() as $post)
                <option value="{{ $post->slug }}" @if ($setting->value == $post->slug) selected @endif >{{ $post->getLongTitle() }}</option>
                @endforeach
            </select>
            <p class="form-info">{{ $setting->description }}</p>
        </div>

        <div class="form-button-group">
            <button type="submit" class="btn btn-green">@lang('Update')</button>
            <button type="reset" class="btn btn-text btn-orange-text">@lang('Clear this form')</button>
        </div>    
    </div>

</form>

@endsection