<!DOCTYPE html>

<html lang="en">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>
@yield('page_title', 'Home') | {{ config('app.name') }}
</title>

<link rel="icon" href="{{ asset('/favicon.ico') }}">

@section('stylesheets')
<link rel="stylesheet" href="{{ asset('/css/app.css') }}" />
<link rel="stylesheet" href="{{ asset('css/fontawesome-all.css') }}" />
@show

</head>

<body
class="theme-cloudy"
style="min-height: 100vh;"
>

<div id="app-container">

@section('navbar')
<nav class="navbar is-bordered" role="navigation" aria-label="main navigation">

<div class="navbar-brand">

<a
id="navbar-sidebar-trigger"
class="sidebar-trigger" 
aria-label="navbar-sidebar-trigger" 
@click.prevent="toggleSidebar"
>
<span></span>
<span></span>
<span></span>
</a>

<a class="navbar-item navbar-logo" href="{{ route('app.home') }}">
<img src="{{ asset('/images/cfs-logo-sm.png') }}" alt="cfs-logo">
</a>

</div>

<div 
id="navbar-menu" 
class="navbar-menu"
ref="navbarMenu"
>

<div class="navbar-end">
@include('app.includes.user_nav')
</div><!-- navbar -->

</div><!-- navbar-menu -->

</nav><!-- navbar -->
@show

@section('sidebar')
<div 
id="sidebar-background" 
class="sidebar-background" 
@click="toggleSidebar(false)"
>
</div>

<div
id="sidebar"
class="sidebar"
ref="sidebar"
>
<div class="sidebar-container">

<div class="sidebar-navbar">

<a 
id="sidebar-trigger"
class="sidebar-trigger" 
aria-label="sidebar-trigger" 
@click.prevent="toggleSidebar"
>
<span></span>
<span></span>
<span></span>
</a>

<a class="navbar-item navbar-logo" href="{{ route('app.home') }}">
<img src="{{ asset('/images/cfs-logo-sm.png') }}" alt="cfs-logo">
</a>

</div>

<div class="sidebar-body">

@section('sidebar_nav_items')
<div class="menu">

@if (Auth::check())
  <p class="menu-label">
  {{ __('messages.label_your_menu') }}
  </p>

  <ul class="menu-list">

  <li>
  <a 
  class="@yield('your_projects_link_active')"
  href=""
  >
  <i class="fas fa-fw fa-project-diagram menu-icon"></i>
  {{ __('messages.label_your_projects') }}
  </a>
  </li>

  <li>
  <a 
  class="@yield('project_create_link_active')"
  href=""
  >
  <i class="fas fa-fw fa-plus menu-icon"></i>
  {{ __('messages.label_new_project') }}
  </a>
  </li>

  <li class="sidebar-divider"></li>

  </ul>
@endif

<p class="menu-label">
{{ __('messages.label_general') }}
</p>

<ul class="menu-list">

<li>
<a 
class="@yield('home_link_active')"
href="{{ route('app.home') }}"
>
<i class="fas fa-fw fa-home menu-icon"></i>
{{ __('messages.label_home') }}
</a>
</li>

<li>
<a 
class="@yield('projects_link_active')"
href="{{ route('blog.projects.list') }}"
>
<i class="fas fa-fw fa-project-diagram menu-icon"></i>
{{ __('messages.label_projects') }}
</a>
</li>

</ul>

</div>
@show

</div><!-- end sidebar-body -->

<div class="sidebar-footer">

<dropdown
id="sidebar-language-selector"
dropdown-classes="is-up"
>

<template slot="dropdown-label">
{{ __('messages.label_language') }}: {{ config('app.locale') }}
</template>

<template slot="dropdown-content">

@foreach (config('app.available_languages') as $key => $language)
  <a 
  id="sidebar-language-{{ $key }}" 
  class="dropdown-item" 
  href="{{ route('language.set_locale', $key) }}"
  >
  {{ $language }}
  </a>
@endforeach

</template>

</dropdown>

</div><!-- end sidebar-footer -->

</div>
</div><!-- end sidebar -->
@show

@yield('full_width_sections')

@section('content_container')
<section class="section main-content">

<div class="columns">
<div class="column is-10 is-offset-1">

@yield('content_top') 
@yield('content')

</div>
</div>

</section>
@show

@section('page_footer')
<div>
<footer class="page-footer is-absolute">

{{ now()->year }} | {{ config('app.name') }}

</footer>
</div>
@show

@yield('modal')

</div><!-- app-container -->

<script>
@section('session_js')
var initSidebarSessionEnabled = false; 
var sidebarExpanded = false;
var appSessionUrl = "";
@show
</script>

@section('scripts')
<script src="{{ asset('js/showdown.min.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/ajax.js') }}"></script>
<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('js/vue/plugins/modal.js') }}"></script>
<script src="{{ asset('js/vue/core-components.js') }}"></script>
<script src="{{ asset('js/vue/app-components.js') }}"></script>
<script src="{{ asset('js/vue/reading-components.js') }}"></script>
<script src="{{ asset('js/vue/dbx-components.js') }}"></script>
<script src="{{ asset('js/vue/directives/vue-scrollto.js') }}"></script>
<script src="{{ asset('js/vue/app.js') }}"></script>
@show

</body>

</html>