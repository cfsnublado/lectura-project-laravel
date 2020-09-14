<post-audios
post-audios-url="{{ $postAudiosUrl }}"
:init-is-admin="{{ json_encode(Auth::check() && Auth::user()->is_superuser) }}"
inline-template
>

<div 
class="post-audios"
v-cloak
>

<div v-if="postAudios && postAudios.length == 0">

<p>{{ __('messages.msg_no_post_audios') }}</p>

@can('createPostAudio', $project)
<a 
class="button is-info" 
href="{{ route('blog.post_audio.create', ['post_id' => $post->id]) }}"
>
{{ __('messages.label_create_post_audio') }}
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

<post-audio
v-for="(postAudio, index) in postAudios"
:key="postAudio.id"
:init-post-audio="postAudio"
:init-is-admin="isAdmin"
init-edit-url="{{ $postAudioEditUrl }}"
init-delete-url="{{ $postAudioDeleteUrl }}"
@delete-post-audio="deletePostAudio(index)"
inline-template
>
<transition name="fade-transition">

<div class="box post-audio-box">

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
delete-confirm-id="delete-post-audio"
:delete-url="deleteUrl"
:id="postAudio.id"
@ajax-success="remove"
inline-template
>

<span class="control">
<a
:id="('post-audio-delete-' + id)"
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
v-html="markdownToHtml(postAudio.name)"
>
</span>
</a>

<div 
class="user-details"
>
{{ __('messages.label_read_by') }}: [[ postAudio.creator_username ]]
</div>

<div 
class="desc"
v-html="markdownToHtml(postAudio.description)"
>
</div>

<div class="player">
<single-audio-player
:audio-player-id="('post-audio-player-' + postAudio.id)"
:audio-url="postAudio.audio_url"
:auto-play="true"
:has-loop-btn="false"
:has-download-btn="false"
:has-mute-btn="false"
:has-stop-btn="false"
:has-volume-btn="false"
inline-template
>

<div 
class="box-audio-player-container center"
v-cloak
>

<audio
:id="audioPlayerId" 
:loop="loop"
preload="auto"
style="display: none;"
>
</audio>

<div 
class="audio-player"
v-bind:class="[{ 'is-loading': loading }]"
>

<div class="audio-player-controls">

<div class="player-control">

<a href="#" v-if="loading">
<i class="fas fa-spinner fa-pulse"></i>
</a>

<a 
href="#"
title="Play/Pause"
@click.prevent="playing = !playing" 
v-else
>
<i v-if="!playing" class="fas fa-play"></i>
<i v-else class="fas fa-pause"></i>
</a>

</div>

<div class="audio-progress-container">

<div class="audio-progress">

<div 
:id="audioPlayerId + '-seekbar'"
class="seek-bar"
@mousedown="onProgressMousedown"
>

<div 
class="play-bar"
:style="{ width: this.percentComplete + '%' }"
>

<div class="bullet"></div>

</div><!-- play-bar -->

</div><!-- seek-bar -->

</div><!-- progress -->

</div><!-- progress-container -->

</div><!-- audio-player-controls -->

</div><!-- audio-player -->

</div><!-- audio-player-container -->

</single-audio-player>
</div>

</div><!-- box-content -->
</div><!-- box -->

</transition>
</post-audio>

</div><!-- processing -->

</div>

</post-audios>
