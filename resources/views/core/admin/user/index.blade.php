@extends ('core.layout.app')

@section ('title', __('Users'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang('New Meta')</h3>
    <p>
        <a href="{{ route('admin.meta.index') }}" class="btn btn-purple">
            @lang('View')
        </a>
    </p>
</div>

<div class="admin-container">
    <h3 class="admin-h3">@lang('Index')</h3>

    <table class="w-full">
        <tr class="border-b">
            <th class="table-cell">@lang('Name')</th>
            <th class="hidden lg:table-cell">@lang('E-mail Address')</th>
            <th class="hidden lg:table-cell">@lang('Joined at')</th>
            <th class="hidden lg:table-cell">@lang('Last Login')</th>
            <th class="hidden lg:table-cell">@lang('Level')</th>
            <th class="table-cell" colspan="2">@lang('Actions')</th>
        </tr>
        @foreach ($users as $user)
        <tr class="border-b border-gray-300 hover:border-blue">
            <td class="table-cell" >{{ $user->name }}</td>
            <td class="hidden lg:table-cell">{{ $user->email }}</td>
            <td class="hidden lg:table-cell">{{ $user->created_at->toFormattedDateString() }}</td>
            <td class="hidden lg:table-cell">{{ $user->meta('last-login') }}</td>
            <td class="hidden lg:table-cell">{{ $user->level() }}</td>
            <td class="table-cell">
                <a href="{{ route('admin.user.edit', $user) }}" class="no-underline">
                    <i class="text-teal" data-feather="edit-3"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection