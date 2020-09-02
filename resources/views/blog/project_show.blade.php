@extends('blog.blog_base')

@section('page_title', $project->name)

@section('page_header')
<div class="page-header"> {{ __('messages.label_posts') }} </div>
@endsection

@section('content')
<div id="projects-scroll-top"></div>

@php
$postsUrl = route(
    'api.blog.project.posts.list',
    ['project' => $project->id]
);
$postUrl = route('blog.post.show', ['slug' => 'zzz']);
$postEditUrl = route('blog.post.edit', ['slug' => 'zzz']);
$postDeleteUrl = route('api.blog.post.destroy', ['post' => 0]);
$projectUrl = route('blog.project.show', ['slug' => $project->slug]);
@endphp

@include('blog.includes.vue.posts')
@endsection

@section('modal')
@include(
'blog/includes/post_delete_modal',
['modalId' => 'delete-post', 'modalName' => 'confirmation-modal']
)
@endsection