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

<a 
class="button is-info" 
href=""
>
{{ __('messages.label_create_post') }}
</a>

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
init-view-url=""
init-delete-url=""
@delete-post="deletePost(index)"
inline-template
>

<transition name="fade-transition">

<div class="box post-box">

<div v-if="isAdmin" class="box-top">

<div class="box-top-left"></div>

<div class="box-top-right">

<div class="box-controls">

<span
class="control"
>
<a
href="#"
@click.prevent="edit"
>
<i class="fas fa-edit fa-fw"></i>
</a>
</span>

<ajax-delete
delete-confirm-id="delete-post"
:delete-url="deleteUrl"
@ajax-success="remove"
inline-template
>

<span class="control">
<a
href="#"
@click.prevent="confirmDelete"
>
<i class="fas fa-times-circle fa-fw"></i>
</a>
</span>

</ajax-delete>

</div><!-- box-controls -->

</div><!-- box-top-right -->

</div><!-- box-top -->

<div class="box-content">

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

<div 
class="desc"
v-html="markdownToHtml(post.description)"
>
</div>

</div><!-- box-content -->
</div><!-- box -->

</transition>

</post>

</div><!-- processing -->

</div>

</posts>
