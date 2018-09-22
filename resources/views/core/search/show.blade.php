@extends ('core.layout.app')

@section ('main')
<div class="admin-container">
    <h3 class="admin-h3">Resultaten</h3>

    <table class="w-full">
        <tr class="border-b">
            <th class="">Title</th>
            <th class="hidden lg:table-cell">Summary</th>
        </tr>

        @forelse ($posts as $post)
        <tr class="border-b border-grey-light hover:border-blue">
            <td class="" >
                <a href="{{ route('post.show', $post) }}">{{ $post->getLongTitle() }}</a>
            </td>

            <td class="hidden lg:table-cell">
                {{ $post->getSummary() }}
            </td>
        </tr>
        @empty
        <tr class="border-b border-grey-light hover:border-blue">
            <td colspan="2" >No results found</td>
        </tr>
        @endforelse
    </table>
</div>
@endsection