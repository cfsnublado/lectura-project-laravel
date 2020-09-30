@extends('blog.blog_base')

@section('page_title', __('messages.page_post_edit_title'))

@section('post_edit_link_active', 'is-active')

@section('page_header')
<div class="page-header"> {{ __('messages.label_edit_post') }} </div>
@endsection

@section('breadcrumb_content')
@parent
<li class="is-active">
<a href="#">{{ __('messages.label_edit_post') }}</a>
</li>
@endsection

@section('content')
@include(
'blog.includes.forms.post_form',
[
    'formId' => 'post-edit-form',
    'formActionUrl' => route('blog.post.update', ['id' => $post->id]),
    'submitLabel' => __('messages.label_update')
]
)
@endsection

@section('modal')
@include(
'blog.includes.post_delete_modal',
['modalId' => 'delete-post', 'modalName' => 'confirmation-modal']
)
@endsection