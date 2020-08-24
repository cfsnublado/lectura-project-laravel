@extends('includes/confirmation_modal')

@section('ok_id', 'project-delete-ok')
@section('cancel_id', 'project-delete-close')

@section('modal_header')
{{ __('messages.msg_confirm_delete_project') }}
@endsection
