@extends ('core.layout.app')

@section ('title', __('Forms'))
    
@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang('Create new form')</h3>
    <p>
        <a href="{{ route('admin.form.create') }}" class="btn btn-teal">
            @lang('Create')
        </a>
    </p>
</div>

<div class="admin-container">
    <h3 class="admin-h3">@lang('Index')</h3>

    <div>
        <div class="hidden lg:flex lg:flex-row">
            <div class="cat-name mr-2 w-1/5">
                <label class="form-label">@lang('Name')</label>
            </div>
            <div class="cat-name flex-1 mr-2">
                <label class="form-label">@lang('Fields')</label>
            </div>
            <div class="cat-name mr-2">
                <label class="form-label">@lang('Action')</label>
            </div>
        </div>
        @forelse ($forms as $form)
        <div class="form flex flex-col lg:flex-row @if (!$loop->last) border-b pb-2 mb-2 @endif ">
            
            <div class="cat-name mr-2 w-1/5">
                <a href="#{{ $form->name }}-{{ $form->id }}" class="text-teal-dark no-underline"><strong>{{ $form->name }}</strong></a>
            </div>
            <div class="flex-1 cat-desc mr-2">
                @foreach ($form->fields as $field)
                    {{ $field->name }}, 
                @endforeach
            </div>
            <div class="cat-actions hidden lg:inline-block">
                {{ $form->action() }}
            </div>            
        </div>
        @empty
            <i>@lang('No forms created yet.')</i>
        @endforelse
                
    </div>
</div>

@foreach ($forms as $form)
<div class="admin-container">
    <h3 class="admin-h3"><a name="{{ $form->name}}-{{ $form->id }}">@lang('Responses'): {{ $form->name }}</a></h3>

    <div>
        @forelse ($form->responses as $response)
        <div class="form flex flex-col lg:flex-row @if (!$loop->last) border-b pb-2 mb-2 @endif ">
            
            <div class="cat-name mr-2 w-1/5 hidden lg:block">
                <label class="form-label" for="name">{{ $form->name }}</label>
            </div>
            <div class="flex-1 cat-desc mr-2">
                @foreach (json_decode($response->content) as $field => $content)
                    @if ($field !== "recaptcha_response")
                        <strong>{{ $field }}</strong>: {{ $content }}<br />
                    @endif
                @endforeach
            </div>
            <div class="cat-actions">
            {{ $response->created_at->diffForHumans() }}
            </div>            
        </div>

        @empty
        <div class="">
            <i>@lang('No responses yet.')</i>
        </div>
        @endforelse
                
    </div>
</div>
@endforeach

@endsection