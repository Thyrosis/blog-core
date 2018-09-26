@extends ('core.layout.app')

@section ('title')
    Categories
@endsection

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">Manage your categories</h3>

    <div class="mb-3">
        <p>An overview of all categories you have defined. Edit names and descriptions or view all posts related to the category.</p>
        <p>Removing a category will only get rid of the category itself. Posts will remain published and available but will no longer be associated with the specific category.</p>
    </div>

    <div>
        <table class="w-full">
            <tr class="border-b">
                <th colspan="2">Name</th>
                <th>Description</th>
                <th>Save</th>
                <th>Posts</th>
                <th>Remove</th>
            </tr>
            
            @foreach ($categories as $category)
                <tr>
                    <td>
                        <form id="form_{{ $category->id }}" name="form_{{ $category->id }}" method="POST" action="{{ route('admin.category.update', $category) }}">
                            @csrf
                            @method('PATCH')
                        </form>
                    </td>

                    <td>
                        <input form="form_{{ $category->id }}" type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="m-1 p-2 shadow border border-teal rounded focus:shadow-inner" />
                    </td>
                    <td class="w-full">
                        <input form="form_{{ $category->id }}" type="text" name="description" id="description" value="{{ old('description', $category->description) }}" class="w-full m-1 p-2 shadow border border-teal rounded focus:shadow-inner" />
                    </td>
                    <td>
                        <button form="form_{{ $category->id }}" type="submit" class="m-1 btn btn-teal">
                            <i data-feather="save"></i>
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('category.show', $category) }}" target="_blank" class="flex items-center m-1 btn btn-blue text-blue-darkest">
                            <div class="mr-2">{{ $category->posts->count() }}</div> 
                            <i data-feather="list"></i>
                        </a>
                    </td>
                    <td>
                        <form id="form_delete_{{ $category->id }}" name="form_delete_{{ $category->id }}" method="POST" action="{{ route('admin.category.destroy', $category) }}" class="mb-0">
                            @csrf
                            @method('DELETE')

                            <button form="form_delete_{{ $category->id }}" type="submit" class="m-1 btn btn-red">
                                <i data-feather="trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            <tr>
                <th colspan="4">Add a new category</th>
            </tr>

            <tr>
                <td>
                    <form id="form_0" name="form_0" method="POST" action="{{ route('admin.category.store') }}">
                        @csrf
                    </form>
                </td>
                <td>
                    <input form="form_0" type="text" name="name" id="name" value="{{ old('name') }}" class="m-1 p-2 shadow border border-teal rounded focus:shadow-inner" placeholder="Name" />
                </td>
                <td class="w-full">
                    <input form="form_0" type="text" name="description" id="description" value="{{ old('description') }}" class="w-full m-1 p-2 shadow border border-teal rounded focus:shadow-inner" placeholder="Description" />
                </td>
                <td>
                    <button form="form_0" type="submit" class="m-1 btn btn-teal">
                        <i data-feather="save"></i>
                    </button>
                </td>
                <td>
                    &nbsp;
                </td>
            </tr>
        </table>
    </div>

@endsection