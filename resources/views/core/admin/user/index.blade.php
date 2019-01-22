@extends ('core.layout.app')

@section ('title', 'Users')

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">Index</h3>

    <table class="w-full">
        <tr class="border-b">
            <th class="table-cell">Name</th>
            <th class="hidden lg:table-cell">Email</th>
            <th class="hidden lg:table-cell">Joined at</th>
            <th class="hidden lg:table-cell">Last Login</th>
            <th class="table-cell" colspan="2">Actions</th>
        </tr>
        @foreach ($users as $user)
        <tr class="border-b border-grey-light hover:border-blue">
            <td class="table-cell" >{{ $user->name }}</td>
            <td class="hidden lg:table-cell">{{ $user->email }}</td>
            <td class="hidden lg:table-cell">{{ $user->created_at->toFormattedDateString() }}</td>
            <td class="hidden lg:table-cell">{{ $user->updated_at->toFormattedDateString() }}</td>
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