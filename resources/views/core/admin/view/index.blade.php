@extends ('core.layout.app')

@section ('title', __('Views'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang('Index')</h3>

    <table class="w-full">
        <tr class="border-b">
            <th class="table-cell">@lang('Post')</th>
            <th class="hidden lg:table-cell">@lang('Date')</th>
            <th class="hidden lg:table-cell">@lang('IP Address')</th>
            <th class="hidden lg:table-cell">@lang('User Agent')</th>
            <th class="table-cell">@lang('Actions')</th>
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