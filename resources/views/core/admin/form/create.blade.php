@extends ('core.layout.app')

@section ('title', 'Forms')
    
@section ('main')

<form method="POST" action="{{ route('admin.form.store') }}" >
    {{ csrf_field() }}
    <div class="admin-container">
        <h3 class="admin-h3">Create new form</h3>
        
        <div class="flex flex-col md:flex-row">
            <div class="mb-5 mx-1 md:w-1/3">
                <label class="form-label" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name" aria-describedby="infoName" />
                <p class="form-info" id="infoName">Name of the form. Mostly just for recognising it.</p>
                @if ($errors->has('name'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('name') }}</span>
                    </div>
                @endif
            </div>

            <div class="mb-5 mx-1 md:w-1/3">
                <label class="form-label" for="action">Action</label>
                <input class="form-control" type="text" name="action" id="action" aria-describedby="infoAction" />
                <p class="form-info" id="infoAction">The action of the form. If empty, defaults to itself. You could action to external sources.</p>
                @if ($errors->has('action'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('action') }}</span>
                    </div>
                @endif
            </div>

            <div class="mb-5 mx-1 md:w-1/3">
                <label class="form-label" for="token">Token</label>
                <input class="form-control" type="text" name="token" id="token" aria-describedby="infoToken" />
                <p class="form-info" id="infoAction">If posting to an external source, you'll probably need some kind of verification token. Set that here.</p>
                @if ($errors->has('token'))
                    <div class="form-error">
                        <i data-feather="alert-triangle"></i> <span class="pl-2">{{ $errors->first('token') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="admin-container">
        <h3 class="admin-h3">Form elements</h3>
        
        <div class="flex flex-col md:flex-row form-info ">
            <div class="m-1 md:w-1/6">
                <strong>Type</strong>: The type of this form-element. Input fields are versatile one-line fields, textareas offer multiple lines of free text and select boxes offer dropdown options.
            </div>
            <div class="m-1 md:w-1/6">
                <strong>Input type</strong>: If you choose the Input type, you can set different subtypes. <i>Text</i> is just any random text, but for instance <i>email address</i> requires the user to fill in an actual email address.
                If type is text, specify a subtype.
            </div>
            <div class="m-1 md:w-1/6">
                <strong>Name</strong>: Unique name, also used as the ID of the form element. You'll see it on the form itself and also on the form submissions in your inbox.
            </div>
            <div class="m-1 md:w-1/6">
                <strong>Class</strong>: By default, we'll give each form element the class <i>form-control</i>. If your CSS specifies another class, you can set it here.
            </div>
            <div class="m-1 md:w-1/6">
                <strong>Description</strong>: It's always good to describe a specific field if it needs some special attention. The description can be used on the front end for your form-information field.
            </div>
            <div class="m-1 md:w-1/6">
                <strong>Required</strong>: Whether the field is required or voluntary.
            </div>
        </div>

        @for ($i = 0; $i < 5; $i++)
        <div class="flex flex-col md:flex-row border p-2 mb-2 items-center	md:border-0 md:p-0" id="formElementRow-{{ $i }}">
            <div class="m-1 md:w-1/6">
                <label for="input" class="form-label md:hidden">Type</label>
                <select aria-describedby="infoInput" class="form-control" id="input" name="input[{{ $i }}]" >
                    <option value="input">Input</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select</option>
                    <option value="button">Button</option>
                </select>
            </div>
            <div class="m-1 md:w-1/6">
                <label for="type" class="form-label md:hidden">Input Type</label>
                <select aria-describedby="infoType" class="form-control" id="type" name="type[{{ $i }}]" >
                    <option value="email">Email address</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="date">Date</option>
                    <option value="file">File</option>
                    <option value="hidden">Hidden</option>
                    <option value="number">Number</option>
                    <option value="password">Password</option>
                    <option value="radio">Radio</option>
                    <option value="range">Range</option>
                    <option value="tel">Phone number</option>
                    <option value="text" selected>Text</option>
                    <option value="url">URL</option>
                </select>
            </div>
            <div class="m-1 md:w-1/6">
                <label for="elementName" class="form-label md:hidden">Name / ID</label>
                <input aria-describedby="infoElementName" class="form-control" id="elementName" name="elementName[{{ $i }}]" placeholder="Name" type="text"  />
            </div>
            <div class="m-1 md:w-1/6">
            <label for="class" class="form-label md:hidden">CSS Class</label>
                <input aria-describedby="infoClass" class="form-control" id="class" name="class[{{ $i }}]" placeholder="Class" type="text" />
            </div>
            <div class="m-1  md:w-1/6">
                <label for="description" class="form-label md:hidden">Description</label>
                <input aria-describedby="infoDescription" class="form-control" id="description" name="description[{{ $i }}]" placeholder="Description" type="text" />
            </div>
            <div class="m-1 md:w-1/6 flex items-center justify-between">
                <div>
                    <label for="required" class="form-label md:hidden">Required</label>
                    <select aria-describedby="infoRequired" class="form-control" id="required" name="required[{{ $i }}]">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div>
                    <span onclick="removeFormRow({{ $i }});"><i class="text-red cursor-pointer" data-feather="trash-2"></i></span>
                </div>
            </div>
        </div>
        @endfor       
    </div>

    <div class="admin-container">
        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">Create</button>
            <button type="reset" class="btn btn-grey">Reset</button>
        </div>
    </div>
</form>
@endsection

@section ('html.body.scripts')

<script>

    function removeFormRow(id)
    {
        var element = document.getElementById('formElementRow-'+id);
        element.parentNode.removeChild(element);
    }

</script>

@endsection