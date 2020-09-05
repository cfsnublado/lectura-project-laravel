@extends('blog.blog_base')

@section('page_title', __('messages.page_project_edit_title'))

@section('project_edit_link_active', 'is-active')

@section('page_header')
<div class="page-header"> {{ __('messages.label_edit_project') }} </div>
@endsection

@section('breadcrumb_content')
@parent
<li class="is-active">
<a href="#">{{ __('messages.label_edit_project') }}</a>
</li>
@endsection

@section('content')
@include('blog.includes.forms.project_edit_form')
@endsection

@section('modal')
@include(
'blog/includes/project_delete_modal',
['modalId' => 'delete-project', 'modalName' => 'confirmation-modal']
)
@endsection