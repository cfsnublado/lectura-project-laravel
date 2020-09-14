@extends('includes/confirmation_modal')

@section('ok_id', 'post-audio-delete-ok')
@section('cancel_id', 'post-audio-delete-close')

@section('modal_header')
{{ __('messages.msg_confirm_delete_post_audio') }}
@endsection
