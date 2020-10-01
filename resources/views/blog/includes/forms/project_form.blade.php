<form 
id="{{ $formId }}" 
action="{{ $formActionUrl }}"
method="post" 
novalidate
>

@csrf

<div class="field">

<label class="label" for="language">
{{ __('messages.label_language') }}
</label>

<div class="control">
<div class="select">
<select id="language" name="language">
@if(isset($project))
@foreach (App\Models\Blog\Project::LANGUAGES as $key => $value)
<option value="{{ $key }}" {{ ($key == $project->language) ? 'selected' : '' }}>
{{ $value }}
</option>
@endforeach
@else
@foreach (App\Models\Blog\Project::LANGUAGES as $key => $value)
<option value="{{ $key }}" {{ ($key == old('language')) ? 'selected' : '' }}>
{{ $value }}
</option>
@endforeach
@endif
</select>
</div>
</div>

</div>

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
value="{{ old('name', (isset($project)) ? $project->name : '') }}"
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
rows="2"
>
{{ old('description', (isset($project)) ? $project->description : '') }}
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
form="{{ $formId }}"
>
{{ $submitLabel }}
</button>

@if(isset($project))
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
@endif

</div>

</form>