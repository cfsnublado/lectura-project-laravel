@extends('blog.blog_base')

@section('page_title', __('messages.page_post_audio_create_title'))

@section('post_audio_create_link_active', 'is-active')

@section('page_header')
<div class="page-header"> {{ __('messages.label_create_post_audio') }} </div>
@endsection

@section('breadcrumb_content')
@parent
<li class="is-active">
<a href="#">{{ __('messages.label_create_post_audio') }}</a>
</li>
@endsection

@section('content')
@include('blog.includes.forms.post_audio_create_form')
@endsection