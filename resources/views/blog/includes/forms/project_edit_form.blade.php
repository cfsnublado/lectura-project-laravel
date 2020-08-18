<form 
id="project-edit-form" 
action="{{ route('blog.project.update', ['id' => $project->id]) }}"
method="post" 
novalidate
>

@csrf

<div class="field">

<label class="label" for="name">
{{ __('messages.label_name') }}
</label>

<div class="control">
<input
id="name"
class="input"
type="text" 
name="name" 
value="{{ old('name', $project->name) }}"
required="required"
>
</div>

<div id="name-errors" class="errors">
@error('name')
<ul class="errorlist">
<li>{{ $message }}</li>
</ul>
@enderror
</div>

</div>

<div class="field">

<label class="label" for="description">
{{ __('messages.label_description') }}
</label>

<div class="control">
<textarea 
id="description"
class="textarea"
name="description" 
cols="40" 
rows="5"
>
{{ old('description', $project->description) }}   
</textarea>
</div>

<div id="description-errors" class="errors">
@error('description')
<ul class="errorlist">
<li>{{ $message }}</li>
</ul>
@enderror
</div>

</div>

<div class="form-buttons">

<button 
id="submit-btn" 
class="button is-info" 
type="submit" 
form="project-edit-form"
>
{{ __('messages.label_update') }}
</button>

<ajax-delete
delete-confirm-id="delete-project"
delete-url="{{ route('api.blog.project.destroy', ['project' => $project->id]) }}" 
delete-redirect-url="{{ route('blog.projects.list') }}"
inline-template
>

<button 
id="project-delete-trigger" 
class="button is-danger"
@click.prevent="confirmDelete"
>
{{ __('messages.label_delete') }}
</button>

</ajax-delete>

</div>

</form>