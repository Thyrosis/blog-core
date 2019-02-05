@extends ('core.layout.app')

@section ('title', 'Views')

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">Index</h3>

    <table class="w-full">
        <tr class="border-b">
            <th class="table-cell">Post</th>
            <th class="hidden lg:table-cell">Date</th>
            <th class="hidden lg:table-cell">IP address</th>
            <th class="hidden lg:table-cell">User Agent</th>
            <th class="table-cell">Actions</th>
        </tr>

        @foreach ($views as $view)
        <tr class="border-b border-grey-light hover:border-blue">
            <td class="table-cell" >{{ $view->post->title }}</td>
            <td class="hidden lg:table-cell">{{ $view->created_at }}</td>
            <td class="hidden lg:table-cell">{{ App\View::decrypt($view->iphash) }}</td>
            <td>{{ App\View::decrypt($view->user_agent) }}</td>
            <td><a href="{{ route('admin.view.show', $view) }}">Meer</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection