@component('mail::message')
# {{ Setting::get('comment.notification.subject') }}

{{ Setting::get('comment.notification.message') }}

@component('mail::panel')
<strong>{{ $comment->post->getLongTitle() }}</strong>
<br />
{{ $comment->created_at->toFormattedDateString() }}

@endcomponent

@component('mail::panel')
<strong>{{ $comment->name }}</strong>
<br />
{{ $comment->body }}
@endcomponent

@component('mail::button', ['url' => $comment->url()])
Lees de hele melding
@endcomponent

@if ($isAdmin == true)
@if ($comment->approved == true)
@component('mail::button', ['url' => route('admin.comment.index'), 'color' => 'success'])
Admin-panel
@endcomponent
@else
@component('mail::button', ['url' => route('admin.comment.index'), 'color' => 'error'])
Approve or delete
@endcomponent
@endif
@endif

{{ Setting::get('comment.notification.salutation') }}<br>
{{ config('app.name') }}
@endcomponent