@extends ('core.layout.app')

@section ('title', __('Settings'))

@section ('main')

<form method="POST" action="">
    @csrf
    @method('PATCH')

    <div class="admin-container">
        @dump($settings)
    </div>

    <div class="admin-container">
        @php
            $setting = $settings->firstWhere('code', 'post.commentable');
        @endphp

        <div class="form-group">
            <label class="form-label" for="post.commentable">{{ $setting->label }}</label>
            <select class="form-control" id="post.commentable" name="post.commentable">
                <option value="0" @if ($setting->value == "0") selected @endif>No</option>
                <option value="1" @if ($setting->value == "1") selected @endif >Yes</option>
            </select>
            <p class="form-info">{{ $setting->description }}</p>        
        </div>
    
    </div>

</form>

@endsection