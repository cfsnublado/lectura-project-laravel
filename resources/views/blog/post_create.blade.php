@extends('blog.blog_base')

@section('page_title', __('messages.page_post_create_title'))

@section('post_create_link_active', 'is-active')

@section('page_header')
<div class="page-header"> {{ __('messages.label_create_post') }} </div>
@endsection

@section('breadcrumb_content')
@parent
<li class="is-active">
<a href="#">{{ __('messages.label_create_post') }}</a>
</li>
@endsection

@section('content')
@include('blog.includes.forms.post_create_form')
@endsection