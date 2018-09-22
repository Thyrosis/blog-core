@extends ('core.layout.app')

@section ('title')
    Subscriptions
@endsection

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">Purge subscriptions</h3>
    <p>
        <b>Warning:</b> Clicking this button will remove all subscriptions connected to unpublished posts.
    </p>
    <p>
        &nbsp;
    </p>
    <p>
        <form class="inline" method="POST" action="{{ route('admin.subscription.destroy') }}">
            @csrf
            @method('DELETE')

            <button class="btn btn-teal">
                Purge
            </button>
        </form>
    </p>
</div>

<div class="admin-container">
    <h3 class="admin-h3">Index</h3>

    @foreach ($subscriptions as $post_id => $subscriptions)
    <div class="mb-5">
        <h3>{{ App\Post::find($post_id)->title }}</h3>
        
        <table>
        @foreach ($subscriptions as $subscription)
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
        @endforeach
        </table>
    </div>
    @endforeach
</div>
@endsection