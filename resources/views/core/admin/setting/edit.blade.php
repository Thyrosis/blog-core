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
            @if ($setting->type == "BOOLEAN")
            <select class="form-control" id="{{ $setting->code }}" name="{{ $setting->code }}">
                <option value="0" @if ($setting->value == "0") selected @endif >@lang('No')</option>
                <option value="1" @if ($setting->value == "1") selected @endif >@lang('Yes')</option>
            </select>
            @elseif ($setting->type == "TEXT") 
            <input class="form-control" id="{{ $setting->code }}" name="{{ $setting->code }}" type="text" value="{{ $setting->value }}" />
            @elseif ($setting->type == "NUMBER")
            <input class="form-control" id="{{ $setting->code }}" name="{{ $setting->code }}" type="number" value="{{ $setting->value }}" />
            @endif
            <p class="form-info">{{ $setting->description }}</p>        
        </div>
        @endforeach

        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">@lang('Update')</button>
            <button type="reset" class="btn btn-grey">@lang('Reset')</button>
        </div>    
    </div>

</form>

@endsection