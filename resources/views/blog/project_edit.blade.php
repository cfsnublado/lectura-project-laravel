@extends('blog.blog_base')

@section('page_title', __('messages.page_project_edit_title'))

@section('project_edit_link_active', 'is-active')

@section('content')
@include('blog.includes.forms.project_edit_form')
@endsection

@section('modal')

@include(
'blog/includes/project_delete_modal',
['modalId' => 'delete-project', 'modalName' => 'confirmation-modal']
)
@endsection