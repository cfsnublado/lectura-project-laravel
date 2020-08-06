<form 
id="login-form" 
action="{{ route('security.authenticate') }}"
method="post" 
novalidate
>

@csrf

@error('credentials')
<ul class="errorlist" style="margin-bottom: 10px;">
<li>{{ $errors->first('credentials') }}</li>
</ul>
@enderror

<div class="field">

<div class="control has-icons-left">

<input
id="username"
class="input"
type="text" 
name="username" 
maxlength="50" 
placeholder="{{ __('messages.placeholder_username') }}"
value="{{ old('username') }}"
required="required"
>

<span class="icon is-small is-left">
<i class="fas fa-user"></i>
</span>

</div>

@error('username')
<ul class="errorlist">
<li>{{ $message }}</li>
</ul>
@enderror

</div>

<div class="field">

<div class="control has-icons-left">

<input 
id="password" 
class="input"
type="password" 
name="password" 
placeholder="{{ __('messages.placeholder_password') }}" 
required="required" 
>

<span class="icon is-small is-left">
<i class="fas fa-lock"></i>
</span>

</div>

@error('password')
<ul class="errorlist">
<li>{{ $message }}</li>
</ul>
@enderror

</div>

<button class="button is-info" type="submit">
{{ __('messages.label_login') }}
</button>

<input type="hidden" name="next" value="next" >

</form>