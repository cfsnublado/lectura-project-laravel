@extends('includes/confirmation_modal')

@section('ok_id') project-delete-ok @endsection
@section('cancel_id') project-delete-close @endsection
@section('modal_header')
{{ __('messages.msg_confirm_delete_project') }}
@endsection
