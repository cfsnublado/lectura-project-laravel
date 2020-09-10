@extends('blog.blog_base')

@section('page_title', __('messages.page_project_create_title'))

@section('page_header')
<div class="page-header"> {{ __('messages.label_create_project') }} </div>
@endsection

@section('project_create_link_active', 'is-active')

@section('content')
@include('blog.includes.forms.project_create_form')
@endsection