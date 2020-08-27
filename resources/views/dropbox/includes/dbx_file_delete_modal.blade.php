@extends('includes/confirmation_modal')

@section('ok_id', 'dbx-file-delete-ok')
@section('cancel_id', 'dbx-file-delete-close')

@section('modal_header')
{{ __('messages.msg_confirm_delete_dbx_file') }}
@endsection
