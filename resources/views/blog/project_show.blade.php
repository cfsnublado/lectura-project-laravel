@extends('blog.blog_base')

@section('page_title', $project->name)

@section('page_header')
<div class="page-header"> {{ __('messages.label_posts') }} </div>
@endsection

@section('content')
<div id="projects-scroll-top"></div>

@include('blog.includes.vue.posts')
@endsection

@section('modal')
@include(
'blog/includes/post_delete_modal',
['modalId' => 'delete-post', 'modalName' => 'confirmation-modal']
)
@endsection