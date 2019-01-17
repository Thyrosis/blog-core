@extends ('core.layout.app')

@section ('title', 'Forms')
    
@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">New Form</h3>
    <p>
        <a href="{{ route('admin.form.create') }}" class="btn btn-teal">
            Create
        </a>
    </p>
</div>

<div class="admin-container">
    <h3 class="admin-h3">Index</h3>

    <table class="admin-table">
        <tr class="admin-table-row-header">
            <th>Name</th>
            <th>Fields</th>
            <th>Action</th>
        </tr>

        @foreach (App\Form::all() as $form)
        <tr class="admin-table-row">
            <td class="admin-table-cell">{{ $form->name }}</td>
            <td>@foreach ($form->fields as $field)
                {{ $field->name }}, 
            @endforeach </td>
            <td>{{ $form->action() }}</td>
        </tr>
        @endforeach
    </table>
</div>

<div class="admin-container">
    <h3 class="admin-h3">Responses</h3>

    @foreach ($forms as $form)
    <table class="admin-table">
        <tr class="admin-table-row-header">
            <th>Form</th>
            <th>Content</th>
            <th>Date</th>
        </tr>

        @forelse ($form->responses as $response)
        <tr class="admin-table-row">
            <td class="admin-table-cell">{{ $form->name }}</td>
            <td> @foreach (json_decode($response->content) as $field => $content)
                <strong>{{ $field }}</strong>: {{ $content }}<br />
            @endforeach </td>
            <td>{{ $response->created_at->diffForHumans() }}</td>
        </tr>
        @empty
        <tr class="admin-table-row">
            <td class="admin-table-cell" colspan="3">
                No responses yet.
            </td>
        </tr>
        @endforelse
    </table>
    @endforeach
</div>

@endsection