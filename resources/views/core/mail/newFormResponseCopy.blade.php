@component('mail::message')
# @lang("New Form Response")

@lang("Thank you for using the form on the website. These are the details you left us.")

@component('mail::panel')
    @foreach ($formResponse->getContent() as $key => $value)
        **{{ ucfirst($key) }}**: {{ $value }}<br />
    @endforeach
@endcomponent

@lang("Kind regards"),<br>
{{ config('app.name') }}
@endcomponent
