@component('mail::message')
# {{ Setting::get('comment.notification.subject') }}

{{ Setting::get('comment.notification.message') }}

@component('mail::panel')
<strong>{{ $comment->name }}</strong>
<br />
{{ $comment->body }}
@endcomponent

@component('mail::button', ['url' => $comment->url()])
Lees de hele melding
@endcomponent

{{ Setting::get('comment.notification.salutation') }}<br>
{{ config('app.name') }}
@endcomponent