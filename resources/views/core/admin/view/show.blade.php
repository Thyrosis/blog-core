@extends ('core.layout.app')

@section ('title', __('Views'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang('View')</h3>

    <table class="w-full">
        <tr class="border-b">
            <th class="table-cell">@lang('Post')</th>
            <th class="hidden lg:table-cell">@lang('Date')</th>
            <th class="hidden lg:table-cell">@lang('IP Address')</th>
            <th class="hidden lg:table-cell">@lang('User Agent')</th>
        </tr>
        <tr>
            <td class="table-cell">{{ $view->post->title }}</td>
            <td class="hidden lg:table-cell">{{ $view->created_at }}</td>
            <td class="hidden lg:table-cell">{{ App\View::decrypt($view->iphash) }}</td>
            <td class="hidden lg:table-cell">{{ App\View::decrypt($view->user_agent) }}</td>
        </tr>
        <tr>
            <th colspan="4">@lang('Related Views')</th>
        </tr>
        @foreach ($view->getSame('user_agent') as $v)
        <tr class="border-b border-gray-300 hover:border-blue">
            <td class="table-cell" >{{ $v->post->title }}</td>
            <td class="hidden lg:table-cell">{{ $v->created_at }}</td>
            <td class="hidden lg:table-cell">{{ App\View::decrypt($v->iphash) }}</td>
            <td>{{ App\View::decrypt($v->user_agent) }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection