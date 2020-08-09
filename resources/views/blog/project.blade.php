@extends('blog.blog_base')

@section('page_title')
{{ $project->name }}
@endsection

@section('content')
<h1>{{ $project->name }}</h1>
@endsection