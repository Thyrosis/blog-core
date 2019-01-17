<form method="POST" action="{{ $form->action() }}">
    {!! $form->csrf() !!}

    @foreach ($form->fields as $field)
    <div class="form-group">
        <label class="form-label" for="{{ $field->elementId }}">{{ $field->name }}</label>
        @if ($field->input == "input")
            <input aria-describedBy="info-{{ $field->elementId }}" type="{{ $field->type }}" name="{{ $field->elementId }}" id="{{ $field->elementId }}" class="{{ $field->class }}" />
        @elseif ($field->input == "textarea")
            <textarea aria-describedBy="info-{{ $field->elementId }}" name="{{ $field->elementId }}" id="{{ $field->elementId }}" class="{{ $field->class }}"></textarea>
        @elseif ($field->input == "select")
            <select aria-describedBy="info-{{ $field->elementId }}" name="{{ $field->elementId }}" id="{{ $field->elementId }}" class="{{ $field->class }}">
                @foreach ($field->options() as $option)
                    <option value="{{ $option['value'] }}">{{ $option['name'] }}</option>
                @endforeach
            </select>
        @endif
        <p class="form-info" id="info-{{ $field->elementId }}">{{ $field->description }}</p>
    </div>
    @endforeach

    <div class="form-group">
        <button type="submit">Send</button>
    </div>
</form>