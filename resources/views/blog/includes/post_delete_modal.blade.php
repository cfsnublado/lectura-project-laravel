@extends('includes/confirmation_modal')

@section('ok_id', 'post-delete-ok')
@section('cancel_id', 'post-delete-close')

@section('modal_header')
{{ __('messages.msg_confirm_delete_post') }}
@endsection
