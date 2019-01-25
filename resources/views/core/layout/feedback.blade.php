@if (session()->has('error'))
<div class="admin-feedback admin-feedback-error">
    {!! session('error') !!}
</div>
@endif

@if (session()->has('warning'))
<div class="admin-feedback admin-feedback-warning">
    {!! session('warning') !!}
</div>
@endif

@if (session()->has('success'))
<div class="admin-feedback admin-feedback-success">
    {!! session('success') !!}
</div>
@endif

@if (session()->has('info'))
<div class="admin-feedback admin-feedback-info">
    {!! session('info') !!}
</div>
@endif

@if (session()->has('status'))
<div class="admin-feedback admin-feedback-status">
    {!! session('status') !!}
</div>
@endif