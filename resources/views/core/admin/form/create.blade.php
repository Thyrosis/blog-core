@extends ('core.layout.app')

@section ('title', 'Forms')
    
@section ('main')

<form method="POST" action="{{ route('admin.form.store') }}" >
    {{ csrf_field() }}
    <div class="admin-container">
        <h3 class="admin-h3">Create new form</h3>
        
        <div class="flex ">
            <div class="mb-5 mr-2">
                <label class="form-label" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name" aria-describedby="infoName" />
                <p class="form-info" id="infoName">Name of the form. Mostly just for recognising it.</p>
            </div>

            <div class="mb-5 mr-2">
                <label class="form-label" for="action">Action</label>
                <input class="form-control" type="text" name="action" id="action" aria-describedby="infoAction" />
                <p class="form-info" id="infoAction">The action of the form. If empty, defaults to itself. You could action to external sources.</p>
            </div>

            <div class="mb-5">
                <label class="form-label" for="token">Token</label>
                <input class="form-control" type="text" name="token" id="token" aria-describedby="infoToken" />
                <p class="form-info" id="infoAction">If posting to an external source, you'll probably need some kind of verification token. Set that here.</p>
            </div>
        </div>
    </div>

    <div class="admin-container">
        <h3 class="admin-h3">Form elements</h3>

        <table>
            <tr>
                <th>Type</th>
                <th>Subtype</th>
                <th>Name/ID</th>
                <th>Class</th>
                <th>Description</th>
            </tr>

            <tr>
                <td><select aria-describedby="infoInput" class="form-control" id="input" name="input[]" >
                    <option value="input">Input</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select</option>
                    <option value="button">Button</option>
                </select></td>
                <td><select aria-describedby="infoType" class="form-control" id="type" name="type[]" >
                    <option value="email">E-mail address</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="date">Date</option>
                    <option value="file">File</option>
                    <option value="hidden">Hidden</option>
                    <option value="number">Number</option>
                    <option value="password">Password</option>
                    <option value="radio">Radio</option>
                    <option value="range">Range</option>
                    <option value="tel">Phone number</option>
                    <option value="text">Text</option>
                    <option value="url">URL</option>
                </select></td>
                <td><input aria-describedby="infoElementName" class="form-control" id="elementName" name="elementName[]" type="text"  /></td>
                <td><input aria-describedby="infoClass" class="form-control" id="class" name="class[]" type="text" /></td>
                <td><input aria-describedby="infoDescription" class="form-control" id="description" name="description[]" type="text" /></td>
            </tr>

            <tr>
                <td><select aria-describedby="infoInput" class="form-control" id="input" name="input[]" >
                    <option value="input">Input</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select</option>
                    <option value="button">Button</option>
                </select></td>
                <td><select aria-describedby="infoType" class="form-control" id="type" name="type[]" >
                    <option value="email">E-mail address</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="date">Date</option>
                    <option value="file">File</option>
                    <option value="hidden">Hidden</option>
                    <option value="number">Number</option>
                    <option value="password">Password</option>
                    <option value="radio">Radio</option>
                    <option value="range">Range</option>
                    <option value="tel">Phone number</option>
                    <option value="text">Text</option>
                    <option value="url">URL</option>
                </select></td>
                <td><input aria-describedby="infoElementName" class="form-control" id="elementName" name="elementName[]" type="text"  /></td>
                <td><input aria-describedby="infoClass" class="form-control" id="class" name="class[]" type="text" /></td>
                <td><input aria-describedby="infoDescription" class="form-control" id="description" name="description[]" type="text" /></td>
            </tr>

            <tr>
                <td><select aria-describedby="infoInput" class="form-control" id="input" name="input[]" >
                    <option value="input">Input</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select</option>
                    <option value="button">Button</option>
                </select></td>
                <td><select aria-describedby="infoType" class="form-control" id="type" name="type[]" >
                    <option value="email">E-mail address</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="date">Date</option>
                    <option value="file">File</option>
                    <option value="hidden">Hidden</option>
                    <option value="number">Number</option>
                    <option value="password">Password</option>
                    <option value="radio">Radio</option>
                    <option value="range">Range</option>
                    <option value="tel">Phone number</option>
                    <option value="text">Text</option>
                    <option value="url">URL</option>
                </select></td>
                <td><input aria-describedby="infoElementName" class="form-control" id="elementName" name="elementName[]" type="text"  /></td>
                <td><input aria-describedby="infoClass" class="form-control" id="class" name="class[]" type="text" /></td>
                <td><input aria-describedby="infoDescription" class="form-control" id="description" name="description[]" type="text" /></td>
            </tr>

            <tr>
                <td><select aria-describedby="infoInput" class="form-control" id="input" name="input[]" >
                    <option value="input">Input</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select</option>
                    <option value="button">Button</option>
                </select></td>
                <td><select aria-describedby="infoType" class="form-control" id="type" name="type[]" >
                    <option value="email">E-mail address</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="date">Date</option>
                    <option value="file">File</option>
                    <option value="hidden">Hidden</option>
                    <option value="number">Number</option>
                    <option value="password">Password</option>
                    <option value="radio">Radio</option>
                    <option value="range">Range</option>
                    <option value="tel">Phone number</option>
                    <option value="text">Text</option>
                    <option value="url">URL</option>
                </select></td>
                <td><input aria-describedby="infoElementName" class="form-control" id="elementName" name="elementName[]" type="text"  /></td>
                <td><input aria-describedby="infoClass" class="form-control" id="class" name="class[]" type="text" /></td>
                <td><input aria-describedby="infoDescription" class="form-control" id="description" name="description[]" type="text" /></td>
            </tr>

            <tr>
                <td><select aria-describedby="infoInput" class="form-control" id="input" name="input[]" >
                    <option value="input">Input</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select</option>
                    <option value="button">Button</option>
                </select></td>
                <td><select aria-describedby="infoType" class="form-control" id="type" name="type[]" >
                    <option value="email">E-mail address</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="date">Date</option>
                    <option value="file">File</option>
                    <option value="hidden">Hidden</option>
                    <option value="number">Number</option>
                    <option value="password">Password</option>
                    <option value="radio">Radio</option>
                    <option value="range">Range</option>
                    <option value="tel">Phone number</option>
                    <option value="text">Text</option>
                    <option value="url">URL</option>
                </select></td>
                <td><input aria-describedby="infoElementName" class="form-control" id="elementName" name="elementName[]" type="text"  /></td>
                <td><input aria-describedby="infoClass" class="form-control" id="class" name="class[]" type="text" /></td>
                <td><input aria-describedby="infoDescription" class="form-control" id="description" name="description[]" type="text" /></td>
            </tr>

            <tr>
                <td class="form-info">Type of element this is.</td>
                <td class="form-info">If type is text, specify a subtype.</td>
                <td class="form-info">Name and unique ID of the element.</td>
                <td class="form-info">Class of the element. Used for CSS on the frontend.</td>
                <td class="form-info">Description to show to customer.</td>
            </tr>
            
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        </table>
      
    </div>

    <div class="admin-container">
        <div class="mb-5 flex" style="justify-content: space-around">
            <button type="submit" class="btn btn-blue">Create</button>
            <button type="reset" class="btn btn-grey">Reset</button>
        </div>
    </div>
</form>
@endsection