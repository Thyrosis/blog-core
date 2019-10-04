@extends ('core.layout.app')

@section ('title', __('Subscriptions'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang('Purge subscriptions')</h3>

    <p>
        @lang('<b>Warning:</b> Clicking this button will remove all subscriptions connected to unpublished posts.')
    </p>

    <p>
        <form class="inline" method="POST" action="{{ route('admin.subscription.destroy') }}">
            @csrf
            @method('DELETE')

            <button class="btn btn-red">
                Purge
            </button>
        </form>
    </p>
</div>

<div class="admin-container">
    <h3 class="admin-h3">@lang('Index')</h3>

    @forelse ($subscriptions as $post_id => $subscriptions)
    <div class="mb-5">
        <h3>{{ App\Post::find($post_id)->title }}</h3>
        
        <table>
        @forelse ($subscriptions as $subscription)
            <tr>
                <td>{{ $subscription->emailaddress }}</td>
                <td>
                    <form class="inline" method="POST" action="{{ route('subscription.destroy', $subscription) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i data-feather="trash-2"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td class="italic" colspan="2">@lang('There are no subscriptions to this post yet')</td>
            </tr>
        @endforelse
        </table>
    </div>
    @empty
        <p class="italic">@lang('There are no posts yet.')</p>
    @endforelse
</div>
@endsection