@extends('layouts.base')

@section('page_title')
{{ __('messages.page_login_title') }}
@endsection

@section('navbar')
@endsection

@section('sidebar')
@endsection

@section('content_container')
<div class="centerall">
<div class="columns is-multiline is-centered is-desktop">

<div class="column is-12 has-text-centered">

<a href="{{ route('app.home') }}">
<img src="{{ asset('/images/cfs-logo-header.png') }}" class="header-logo" alt="logo">
</a>

</div>

<div class="column is-12">

@include('security.includes.login_form')

<div style="margin-top: 20px;">
<a href="">
{{ __('messages.msg_forgot_password_q') }}
</a>
</div>

<div style="margin-top: 20px;">
<a
class="button"
href=""
>
<span class="icon"><i class="fab fa-google"></i></span>
<span>{{ __('messages.label_login_google') }}</span>
</a>
</div>

</div><!-- column -->

</div><!-- columns -->
</div><!-- centerall -->
@endsection
