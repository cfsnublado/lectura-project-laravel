<posts
posts-url="{{ $postsUrl }}"
:init-is-admin="{{ json_encode(Auth::check() && Auth::user()->is_superuser) }}"
inline-template
>

<div
class="posts"
v-cloak
>

<div v-if="posts && posts.length == 0">

<p>{{ __('messages.msg_no_posts_in_project') }}</p>

@can('createPost', $project)
<a 
class="button is-info" 
href="{{ route('blog.post.create', ['project_slug' => $project->slug]) }}"
>
{{ __('messages.label_create_post') }}
</a>
@endcan

</div>

<div 
v-if="processing"
class="processing-icon is-centered is-large"
>
<i class="fas fa-cog fa-spin"></i>
</div>

<div v-else>

<post
v-for="(post, index) in posts"
:key="post.id"
:init-post="post"
:init-is-admin="isAdmin"
init-view-url="{{ $postUrl }}"
init-edit-url="{{ $postEditUrl }}"
init-delete-url="{{ $postDeleteUrl }}"
@delete-post="deletePost(index)"
inline-template
>

<transition name="fade-transition">

<div class="box post-box">

<article class="media">

<div class="media-content">

<a
href="#"
@click.prevent="view"
>
<span
class="name"
v-html="markdownToHtml(post.name)"
>
</span>
</a>

<small>
<div 
class="desc"
v-html="markdownToHtml(post.description)"
>
</div>
</small>

</div><!-- media-content -->

<div v-if="isAdmin" class="media-right">

<span class="control">
<a
:id="('post-edit-' + post.id)"
href="#"
@click.prevent="edit"
>
<i class="fas fa-edit fa-fw"></i>
</a>
</span>

<ajax-delete
delete-confirm-id="delete-post"
:delete-url="deleteUrl"
:id="post.id"
@ajax-success="remove"
inline-template
>
<span class="control">
<a
:id="('post-delete-' + id)"
href="#"
@click.prevent="confirmDelete"
>
<i class="fas fa-times-circle fa-fw"></i>
</a>
</span>
</ajax-delete>


</div><!-- media-right -->

</div>

</transition>

</post>

</div><!-- processing -->

</div>

</posts>
