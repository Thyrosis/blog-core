@extends ('core.layout.app')

@section ('title', 'Views')

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">View</h3>

    <table class="w-full">
        <tr class="border-b">
            <th class="table-cell">Post</th>
            <th class="hidden lg:table-cell">Date</th>
            <th class="hidden lg:table-cell">IP address</th>
            <th class="hidden lg:table-cell">User Agent</th>
        </tr>
        <tr>
            <td class="table-cell">{{ $view->post->title }}</td>
            <td class="hidden lg:table-cell">{{ $view->created_at }}</td>
            <td class="hidden lg:table-cell">{{ App\View::decrypt($view->iphash) }}</td>
            <td class="hidden lg:table-cell">{{ App\View::decrypt($view->user_agent) }}</td>
        </tr>
        <tr>
            <th colspan="4">Related views</th>
        </tr>
        @foreach ($view->getSame('user_agent') as $v)
        <tr class="border-b border-grey-light hover:border-blue">
            <td class="table-cell" >{{ $v->post->title }}</td>
            <td class="hidden lg:table-cell">{{ $v->created_at }}</td>
            <td class="hidden lg:table-cell">{{ App\View::decrypt($v->iphash) }}</td>
            <td>{{ App\View::decrypt($v->user_agent) }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection