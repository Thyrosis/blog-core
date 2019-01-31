@component('mail::message')
# New Form Response

Thank you for using the website {{ config('app.url') }}. These are the details you left us.

@component('mail::panel')
    @foreach ($formResponse->getContent() as $key => $value)
        {{ $key }}: {{ $value }}<br />
    @endforeach
@endcomponent

Kind regards,<br>
{{ config('app.name') }}
@endcomponent
