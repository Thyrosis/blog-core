@component('mail::message')
# Nieuwe Reactie op {{ $comment->post->title }}

{{ $comment->name }} reageert net op een artikel waar jij ook op gereageerd hebt.

@component('mail::panel')
{{ $comment->body }}
@endcomponent

@component('mail::button', ['url' => $comment->url()])
Alles lezen
@endcomponent

Groetjes,<br>
{{ config('app.name') }}
@endcomponent