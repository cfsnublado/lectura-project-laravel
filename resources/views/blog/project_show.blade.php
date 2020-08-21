@extends('blog.blog_base')

@section('page_title') {{ $project->name }} @endsection

@section('content')
<div id="projects-scroll-top"></div>

@php
$postsUrl = route(
    'api.blog.project.posts.list',
    ['project' => $project->id]
);
$projectUrl = route('blog.project.show', ['slug' => $project->slug]);
@endphp

@include('blog.includes.vue.posts')
@endsection