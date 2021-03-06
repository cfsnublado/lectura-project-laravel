<form 
id="{{ $formId }}" 
action="{{ $formActionUrl }}"
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
value="{{ old('name', (isset($postAudio)) ? $postAudio->name : '') }}"
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
{{ old('description', (isset($postAudio)) ? $postAudio->description : '') }} 
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

<label class="label" for="audio_url">
{{ __('messages.label_audio_url') }}
</label>

<div class="control">
<input
id="audio_url"
class="input"
type="text" 
name="audio_url" 
value="{{ old('audio_url', (isset($postAudio)) ? $postAudio->audio_url : '') }}"
required="required"
>
</div>

<div id="audio-url-errors" class="errors">
@error('audio_url')
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

</div>

</form>