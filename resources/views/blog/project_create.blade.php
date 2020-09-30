@extends('blog.blog_base')

@section('page_title', __('messages.page_project_create_title'))

@section('page_header')
<div class="page-header"> {{ __('messages.label_create_project') }} </div>
@endsection

@section('breadcrumb_content')
@parent
<li>
<a href="{{ route('blog.projects.list') }}">
{{ __('messages.label_projects') }}
</a>
</li>
<li class="is-active">
<a href="#">{{ __('messages.label_create_project') }}</a>
</li>
@endsection

@section('project_create_link_active', 'is-active')

@section('content')
@include(
'blog.includes.forms.project_form',
[
    'formId' => 'project-create-form',
    'formActionUrl' => route('blog.project.store'),
    'submitLabel' => __('messages.label_create')
]
)
@endsection