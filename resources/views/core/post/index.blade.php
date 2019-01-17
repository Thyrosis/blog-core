@extends ('core.layout.app')

@section ('main')

    @foreach ($posts as $post)
        @includeFirst(['core.category._single', 'core.post._single'], ['post' => $post])
    @endforeach

    {{ $posts->links() }} 

    @include ('core.search._create')

    @include ('core.admin.form._show', ['form' => App\Form::find(7)])

@endsection