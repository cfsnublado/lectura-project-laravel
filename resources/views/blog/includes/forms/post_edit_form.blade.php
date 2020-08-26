<form 
id="post-edit-form" 
action="{{ route('blog.post.update', ['id' => $post->id]) }}"
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
value="{{ old('name', $post->name) }}"
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
{{ old('description', $post->description) }}   
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
rows="8"
>
{{ old('content', $post->content) }}   
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
form="post-edit-form"
>
{{ __('messages.label_update') }}
</button>

<ajax-delete
delete-confirm-id="delete-post"
delete-url="{{ route('api.blog.post.destroy', ['post' => $post->id]) }}" 
delete-redirect-url="{{ route('blog.project.show', ['slug' => $project->slug]) }}"
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