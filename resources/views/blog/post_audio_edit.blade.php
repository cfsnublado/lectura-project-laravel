@extends('blog.blog_base')

@section('page_title', __('messages.page_post_audio_edit_title'))

@section('post_audio_edit_link_active', 'is-active')

@section('page_header')
<div class="page-header">
{{ __('messages.label_edit_post_audio') }}
</div>
@endsection

@section('breadcrumb_content')
@parent
<li class="is-active">
<a href="#">{{ __('messages.label_edit_post_audio') }}</a>
</li>
@endsection

@section('content')
@include(
'blog.includes.forms.post_audio_form',
[
    'formId' => 'post-audio-edit-form',
    'formActionUrl' => route('blog.post_audio.update', ['id' => $postAudio->id]),
    'submitLabel' => __('messages.label_update')
]
)
@endsection