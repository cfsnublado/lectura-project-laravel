<projects
projects-url="{{ $projectsUrl }}"
:init-is-admin="@if (Auth::check() && Auth::user()->is_superuser) true @else false @endif"
inline-template
>

<div 
class="projects"
v-cloak
>

<div v-if="projects && projects.length == 0">

<p>{{ __('messages.msg_no_projects') }}</p>

<a class="button is-info" href="">
{{ __('messages.label_create_project') }}
</a>

</div>

<div 
v-if="processing"
class="processing-icon is-centered is-large"
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
init-edit-url="{{ $projectUpdateUrl }}"
init-delete-url="{{ $projectDeleteUrl }}"
@delete-project="deleteProject(index)"
inline-template
>
<transition name="fade-transition">

<div class="box project-box">

<div class="box-top">

<div class="box-top-left"></div>

<div class="box-top-right">

<div class="box-controls">

<span
v-if="isAdmin"
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
v-if="isAdmin"
delete-confirm-id="delete-project"
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
v-html="markdownToHtml(project.name)"
>
</span>
</a>

<div 
class="desc"
v-html="markdownToHtml(project.description)"
>
</div>

</div><!-- box-content -->
</div><!-- box -->

</transition>
</project>

</div><!-- processing -->

</div>

</projects>
