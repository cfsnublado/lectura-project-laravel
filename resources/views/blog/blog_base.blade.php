@extends('layouts.base')

@section('body_classes')
sidebar-adaptable theme-cloudy @if(Session::get('sidebar_locked', false)) sidebar-expanded @endif
@endsection

@section('content_top')

@section('project_header') 
@if(isset($project))
<div class="small-caps-header">{{ $project->name }}</div>
@endif
@show

@yield('page_header')

@section('breadcrumbs')
<nav class="breadcrumb">
<ul>
@section('breadcrumb_content')
@include('blog/includes/breadcrumbs')
@show
</ul>
</nav>
@show

@endsection

@section('sidebar_nav_items')
@if(isset($project))
<div class="menu">

<p class="menu-label">
{{ __('messages.label_project') }}
</p>

<p class="menu-header">
<a id="sidebar-nav-project-name" href="{{ route('blog.project.show', ['slug' => $project->slug]) }}">
<span id="menu-project-name"> {{ $project->name }} </span>
</a>
</p>

<ul class="menu-list">

@can('update', $project)
<li>
<a 
id="sidebar-nav-project-edit" 
class="@yield('project_edit_link_active')" 
href="{{ route('blog.project.edit', ['slug' => $project->slug]) }}"
>
<i class="menu-icon fas fa-edit fa-fw"></i> 
{{ __('messages.label_edit_project') }}
</a>
</li>

<li>
<a 
id="sidebar-nav-project-download" 
href="{{ route('blog.project.download', ['id' => $project->id]) }}"
>
<i class="menu-icon fas fa-download fa-fw"></i> 
{{ __('messages.label_export_project') }}
</a>
</li>
@endcan

@can('createPost', $project)
<li>
<a 
id="sidebar-nav-post-create" 
class="@yield('post_create_link_active')" 
href="{{ route('blog.post.create', ['project_slug' => $project->slug]) }}"
>
<i class="menu-icon fas fa-plus fa-fw"></i>
{{ __('messages.label_new_post') }}
</a>
</li>
@endcan

</ul>
</div>

<span class="sidebar-divider"></span>
@endif

@if(isset($post))
<div class="menu">

<p class="menu-label">
{{ __('messages.label_post') }}
</p>

<p class="menu-header">
<a id="sidebar-nav-post-name" href="{{ route('blog.post.show', ['slug' => $post->slug]) }}">
<span id="menu-post-name"> {{ $post->name }} </span>
</a>
</p>

<ul class="menu-list">

@can('update', $post)
<li>
<a 
id="sidebar-nav-post-edit" 
class="@yield('post_edit_link_active')" 
href="{{ route('blog.post.edit', ['slug' => $post->slug]) }}"
>
<i class="menu-icon fas fa-edit fa-fw"></i> 
{{ __('messages.label_edit_post') }}
</a>
</li>

<li>
<a 
id="sidebar-nav-post-download" 
href="{{ route('blog.post.download', ['id' => $post->id]) }}"
>
<i class="menu-icon fas fa-download fa-fw"></i> 
{{ __('messages.label_export_post') }}
</a>
</li>
@endcan

<li>
<a 
id="sidebar-nav-post-audios" 
class="@yield('post_audios_link_active')" 
href="{{ route('blog.post.post_audios.list', ['post_id' => $post->id]) }}"
>
<i class="menu-icon fas fa-music fa-fw"></i>
{{ __('messages.label_post_audios') }}
</a>
</li>

@can('createPostAudio', $project)
<li>
<a 
id="sidebar-nav-post-audio-create" 
class="@yield('post_audio_create_link_active')" 
href="{{ route('blog.post_audio.create', ['post_id' => $post->id]) }}"
>
<i class="menu-icon fas fa-microphone fa-fw"></i>
{{ __('messages.label_new_post_audio') }}
</a>
</li>
@endcan

</ul>
</div>

<span class="sidebar-divider"></span>
@endif

@parent
@endsection

@section('session_js')
var initSidebarSessionEnabled = true
var sidebarExpanded = {{ json_encode(Session::get('sidebar_locked', false)) }}
var appSessionUrl = "{{ route('app.session') }}"
@endsection