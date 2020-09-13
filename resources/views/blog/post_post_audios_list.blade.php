@extends('blog.blog_base')

@section('page_title', __('messages.page_post_audios_title'))

@section('post_audios_link_active', 'is-active')

@section('page_header')
<div class="page-header"> {{ __('messages.label_post_audios') }} </div>
@endsection

@section('content')
<div id="post-audios-scroll-top"></div>
@include('blog.includes.vue.post_audios')
@endsection

@section('modal')
@endsection