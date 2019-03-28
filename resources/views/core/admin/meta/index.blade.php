@extends ('core.layout.app')

@section ('title', __('Metas'))

@section ('main')

<div class="admin-container">
    <h3 class="admin-h3">@lang('Create new meta information')</h3>

    <div class="meta flex flex-col lg:flex-row">
        <form id="form_0" name="form_0" method="POST" action="{{ route('admin.meta.store') }}">
            @csrf
            <input id="system" name="system" type="hidden" value="0" />
        </form>

        <div class="meta-label mr-3">
            <label class="form-label" for="label">@lang('Label')</label>
            <input form="form_0" type="text" name="label" id="label" value="{{ old('label') }}" class="form-control" placeholder="@lang('Your label')" />
        </div>
        <div class="flex-1 meta-desc mr-3">
            <label class="form-label" for="description">@lang('Description')</label>
            <input form="form_0" type="text" name="description" id="description" value="{{ old('description') }}" class="form-control" placeholder="@lang('Your description')" />
        </div>
        <div class="meta-updateable mr-3">
            <label class="form-label" for="updateable">@lang('Updateable')</label>
            <select class="form-control" form="form_0" id="updateable" name="updateable">
                <option value="0">@lang('No')</option>
                <option value="1" selected>@lang('Yes')</option>
            </select>
        </div>
        <div class="meta-actions">
            <label class="form-label">@lang('Actions')</label>
            <div class="flex">
                <div class="meta-save">
                    <button form="form_0" type="submit" class="m-1 btn-small btn-teal">
                        <i data-feather="save"></i>
                    </button>
                </div>
            </div>
        </div>            
    </div>
</div>


<div class="admin-container">
    <h3 class="admin-h3">@lang('Manage your metas')</h3>

    <div class="mb-3">
        @lang('<p>An overview of all metas you have defined. Edit names and descriptions or view all posts related to the meta.</p><p>Removing a meta will only get rid of the meta itself. Posts will remain published and available but will no longer be associated with the specific meta.</p>')
    </div>

    <div>
        @foreach ($metas as $meta)
        
        <div class="meta flex flex-col lg:flex-row">
            <form id="form_{{ $meta->id }}" name="form_{{ $meta->id }}" method="POST" action="{{ route('admin.meta.update', $meta) }}">
                @csrf
                @method('PATCH')
            </form>

            <div class="meta-label mr-3">
                <label class="form-label" for="label">@lang('Label')</label>
                <input form="form_{{ $meta->id }}" type="text" name="label" id="label" value="{{ old('label', $meta->label) }}" class="form-control" />
            </div>
            <div class="flex-1 meta-desc mr-3">
                <label class="form-label" for="description">@lang('Description')</label>
                <input form="form_{{ $meta->id }}" type="text" name="description" id="description" value="{{ old('description', $meta->description) }}" class="form-control" />
            </div>
            <div class="meta-actions">
                <label class="form-label">@lang('Actions')</label>
                <div class="flex">
                    <div class="meta-save">
                        <button form="form_{{ $meta->id }}" type="submit" class="m-1 btn-small btn-teal">
                            <i data-feather="save"></i>
                        </button>
                    </div>
                    <div class="meta-remove">
                        <form id="form_delete_{{ $meta->id }}" name="form_delete_{{ $meta->id }}" method="POST" action="{{ route('admin.meta.destroy', $meta) }}" class="mb-0">
                            @csrf
                            @method('DELETE')

                            <button form="form_delete_{{ $meta->id }}" type="submit" class="m-1 btn-small btn-red">
                                <i data-feather="trash-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>            
        </div>
        @endforeach
    </div>
</div>

@endsection