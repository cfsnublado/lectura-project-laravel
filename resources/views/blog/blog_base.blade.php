@extends('layouts.base')

@section('body_classes')
sidebar-adaptable theme-cloudy @if(Session::get('sidebar_locked', false)) sidebar-expanded @endif
@endsection

@section('content_top')
@section('project_header') @endsection
@endsection

@section('session_js')
var initSidebarSessionEnabled = true
var sidebarExpanded = {{ json_encode(Session::get('sidebar_locked', false)) }}
var appSessionUrl = "{{ route('app.session') }}"
@endsection