@extends('blog.blog_base')

@section('page_title', $project->name)

@section('page_header')
<div class="page-header"> {{ __('messages.label_posts') }} </div>
@endsection

@section('content')
<div id="projects-scroll-top"></div>

<div class="columns is-multiline">
<div class="column is-8 is-offset-2">
@include('blog.includes.vue.posts')
</div>
</div>
@endsection

@section('modal')
@include(
'blog/includes/post_delete_modal',
['modalId' => 'delete-post', 'modalName' => 'confirmation-modal']
)
@endsection