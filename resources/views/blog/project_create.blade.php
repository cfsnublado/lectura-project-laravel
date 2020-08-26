@extends('blog.blog_base')

@section('page_title', __('messages.page_project_create_title'))

@section('project_create_link_active', 'is-active')

@section('content')
@include('blog.includes.forms.project_create_form')
@endsection