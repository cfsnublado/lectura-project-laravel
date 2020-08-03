@extends('layouts.base')

@section('page_title')
{{ __('messages.page_home_title') }}
@endsection

@section('full_width_sections')
<section id="intro" class="parallax-block intro">

<div class="columns">
<div class="column">

<div class="parallax-body">

<h1 class="is-size-1 is-size-2-mobile"> {{ config('app.name') }} </h1>

<h2 class="is-size-3 is-size-4-mobile">
{{ __('messages.msg_project_banner_desc') }}
</h2>

</div>

</div>
</div>

</section>

<div class="page-sections">

<section class="section page-section icon-blocks">

<div class="columns">
<div class="column is-10 is-offset-1">

<h2 class="page-section-header icon-blocks-header">
{{ __('messages.msg_lectura_at_a_glance') }}
</h2>

<div class="columns is-multiline">

<div class="column is-6 icon-block">

<header class="icon-block-header">

<i class="fas fa-music icon-block-icon"></i>

<h3>{{ __('messages.msg_block_1') }}</h3>

</header>

<p>
{{ __('messages.msg_block_1_desc') }}
</p>

</div>

<div class="column is-6 icon-block">

<i class="fas fa-users icon-block-icon"></i>

<header class="icon-block-header">
<h3>{{ __('messages.msg_block_2') }}</h3>
</header>

<p>
{{ __('messages.msg_block_2_desc') }}
</p>

</div>

</div>

</div>
</div>

</section>
</div>
@endsection