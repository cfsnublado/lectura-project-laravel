<projects
projects-url="{{ $projectsUrl }}"
:init-is-admin="{{ json_encode(Auth::check() && Auth::user()->is_superuser) }}"
inline-template
>

<div 
class="projects"
v-cloak
>

<div v-if="projects && projects.length == 0">

<p>{{ __('messages.msg_no_projects') }}</p>

@can('create', App\Models\Blog\Project::class)
<a class="button is-info" href="{{ route('blog.project.create') }}">
{{ __('messages.label_create_project') }}
</a>
@endcan

</div>

<div 
v-if="processing"
class="processing-icon is-large"
>
<i class="fas fa-cog fa-spin"></i>
</div>

<div v-else>

<project
v-for="(project, index) in projects"
:key="project.id"
:init-project="project"
:init-is-admin="isAdmin"
init-view-url="{{ $projectUrl }}"
init-edit-url="{{ $projectEditUrl }}"
init-delete-url="{{ $projectDeleteUrl }}"
@delete-project="deleteProject(index)"
inline-template
>
<transition name="fade-transition">

<div class="box project-box">

<article class="media">

<div class="media-content">

<a
href="#"
@click.prevent="view"
>
<div
class="name"
v-html="markdownToHtml(project.name)"
>
</div>
</a>

<small>
<div 
class="desc"
v-html="markdownToHtml(project.description)"
>
</div>
</small>

</div>

<div v-if="isAdmin" class="media-right">

<span class="control">
<a
:id="('project-edit-' + project.id)"
href="#"
@click.prevent="edit"
>
<i class="fas fa-edit fa-fw"></i>
</a>
</span>

<ajax-delete
delete-confirm-id="delete-project"
:delete-url="deleteUrl"
:id="project.id"
@ajax-success="remove"
inline-template
>

<span class="control">
<a
:id="('project-delete-' + id)"
href="#"
@click.prevent="confirmDelete"
>
<i class="fas fa-times-circle fa-fw"></i>
</a>
</span>

</ajax-delete>

</div>

</article>

</div><!-- box -->

</transition>
</project>

</div><!-- processing -->

</div>

</projects>
