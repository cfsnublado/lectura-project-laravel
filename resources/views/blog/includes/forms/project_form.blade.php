<form 
id="project-form" 
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
value="{{ $project->name }}"
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
{{ $project->description }}   
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

</form>