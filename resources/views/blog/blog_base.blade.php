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