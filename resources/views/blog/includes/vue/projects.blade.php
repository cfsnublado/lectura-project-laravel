<projects
projects-url="{{ $projects_url }}"
:init-is-admin="false"
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
init-view-url="{{ $project_url }}"
init-edit-url="{{ $project_update_url }}"
init-delete-url="{{ $project_delete_url }}"
@delete-project="onDeleteProject(index)"
inline-template
>
<transition name="fade-transition" v-on:after-enter="isVisible = true" v-on:after-leave="remove">

<div class="card project-card" v-show="isVisible">

<div class="card-controls">

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
@ajax-success="isVisible = false"
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

</div>

<div class="card-content">

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

</div>
</div>

</transition>
</project>

</div><!-- processing -->

</div>

</projects>
