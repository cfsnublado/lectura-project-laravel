@if(isset($project))
  <li>
  <a href="{{ route('blog.projects.list') }}">
  {{ __('messages.label_projects') }}
  </a>
  </li>
  @if(Route::currentRouteName() == 'blog.project.show')
    <li class="is-active">
    <a class="is-active" href="#">{{ $project->name }}</a>
    </li>
  @else
    <li>
    <a href="{{ route('blog.project.show', ['slug' => $project->slug]) }}">
    {{ $project->name }}
    </a>
    </li>
    @if(isset($post))
      @if(Route::currentRouteName() == 'blog.post.show')
        <li class="is-active">
        <a class="is-active" href="#">{{ $post->name }}</a>
        </li>
      @else
        <li>
        <a href="{{ route('blog.post.show', ['slug' => $post->slug]) }}">
        {{ $post->name }}
        </a>
        </li>
      @endif
    @endif
  @endif
@endif