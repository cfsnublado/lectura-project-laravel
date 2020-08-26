@extends('blog.blog_base')

@section('page_title', __('messages.page_projects_title'))

@section('projects_link_active', 'is-active')

@section('content')
<div id="projects-scroll-top"></div>

@php
$projectsUrl = route('api.blog.projects.list');
$projectUrl = route('blog.project.show', ['slug' => 'zzz']);
$projectEditUrl = route('blog.project.edit', ['slug' => 'zzz']);
$projectDeleteUrl = route('api.blog.project.destroy', ['project' => 0]);
@endphp

@include('blog.includes.vue.projects')
@endsection

@section('modal')
@include(
'blog/includes/project_delete_modal',
['modalId' => 'delete-project', 'modalName' => 'confirmation-modal']
)
@endsection