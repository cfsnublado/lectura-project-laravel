@extends('blog.blog_base')

@section('page_title', __('messages.page_projects_title'))

@section('projects_link_active', 'is-active')

@section('page_header')
<div class="page-header"> {{ __('messages.label_projects') }} </div>
@endsection

@section('content')
<div id="projects-scroll-top"></div>

@include('blog.includes.vue.projects')
@endsection

@section('modal')
@include(
'blog/includes/project_delete_modal',
['modalId' => 'delete-project', 'modalName' => 'confirmation-modal']
)
@endsection