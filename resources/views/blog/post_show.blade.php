@extends('blog.blog_base')

@section('page_title', $post->name)

@section('content')
<div class="post-view">

<div class="post-name">
<h2>{{ $post->name }}</h2>
</div>

<div class="post-desc">
@if(isset($post->description))@markdown($post->description)@endif
</div>

<div class="post-content">
@if(isset($post->content))@markdown($post->content)@endif
</div>

</div><!-- post-view -->
@endsection