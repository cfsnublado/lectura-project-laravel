@extends('blog.blog_base')

@section('page_title', __('messages.page_post_audios_title'))

@section('post_audios_link_active', 'is-active')

@section('page_header')
<div class="page-header">
{{ __('messages.label_post_audios') }}: {{ $post->name }}
</div>
@endsection

@section('breadcrumb_content')
@parent
<li class="is-active">
<a href="#">{{ __('messages.label_post_audios') }}</a>
</li>
@endsection

@section('content')
<div id="post-audios-scroll-top"></div>
@include('blog.includes.vue.post_audios')
@endsection

@section('modal')
@endsection