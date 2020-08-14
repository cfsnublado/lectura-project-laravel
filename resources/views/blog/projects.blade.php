@extends('blog.blog_base')

@section('page_title')
{{ __('messages.page_projects_title') }}
@endsection

@section('projects_link_active')
is-active
@endsection

@section('content')
<div id="projects-scroll-top"></div>

@php
$projects_url = route('api.blog.projects.list');
$project_url = route('blog.project', ['slug' => 'zzz']);
$project_update_url = '';
$project_delete_url = route('api.blog.project.destroy', ['project' => 0]);
$modal_id = 'delete-project';
$modal_name = 'confirmation-modal';
@endphp

@include('blog.includes.vue.projects')

@endsection

@section('modal')

@include('blog/includes/project_delete_modal')

@endsection