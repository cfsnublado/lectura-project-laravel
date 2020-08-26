@extends('blog.blog_base')

@section('page_title', __('messages.page_post_edit_title'))

@section('post_edit_link_active', 'is-active')

@section('content')
@include('blog.includes.forms.post_edit_form')
@endsection

@section('modal')
@include(
'blog/includes/post_delete_modal',
['modalId' => 'delete-post', 'modalName' => 'confirmation-modal']
)
@endsection