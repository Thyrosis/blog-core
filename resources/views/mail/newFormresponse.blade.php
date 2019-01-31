@component('mail::message')
# New Form Response

A new response was left using your form **{{ $formResponse->form->name }}**

@component('mail::panel')
    @foreach ($formResponse->getContent() as $key => $value)
        {{ $key }}: {{ $value }}<br />
    @endforeach
@endcomponent

@component('mail::button', ['url' => route('admin.form.index')."#".$formResponse->form->name."-".$formResponse->form->id])
View in dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
