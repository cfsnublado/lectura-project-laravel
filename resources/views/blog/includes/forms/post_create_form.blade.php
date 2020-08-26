<form 
id="post-create-form" 
action="{{ route('blog.post.store', ['projectId' => $project->id]) }}"
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
value="{{ old('name') }}"
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
rows="3"
>
{{ old('description') }}   
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

<div class="field">

<label class="label" for="content">
{{ __('messages.label_content') }}
</label>

<div class="control">
<textarea 
id="content"
class="textarea"
name="content" 
cols="40" 
rows="10"
>
{{ old('content') }}   
</textarea>
</div>

<div id="content-errors" class="errors">
@error('content')
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
form="post-create-form"
>
{{ __('messages.label_create') }}
</button>

</div>

</form>