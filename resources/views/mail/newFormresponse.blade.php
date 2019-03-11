@component('mail::message')
# @lang("New Form Response")

@lang("One of your forms was used at your website.")

@component('mail::panel')
        **@lang("Form")**: {{ $formResponse->form->name }}<br />
    @foreach ($formResponse->getContent() as $key => $value)
        **{{ ucfirst($key) }}**: {{ $value }}<br />
    @endforeach
@endcomponent

@component('mail::button', ['url' => route('admin.form.index')."#".$formResponse->form->name."-".$formResponse->form->id])
    @lang("View in dashboard")
@endcomponent

@lang("Kind regards"),<br>
{{ config('app.name') }}
@endcomponent
