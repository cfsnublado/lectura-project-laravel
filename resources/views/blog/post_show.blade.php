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

@section('page_footer')
@if($hasAudio)
<playlist-audio-player
audio-player-id="post-audio"
audios-url="{{ $postAudiosUrl }}"
:auto-load-playlist="false"
:auto-play="true"
:has-loop-btn="false"
:has-download-btn="false"
:has-mute-btn="false"
:has-stop-btn="false"
:has-volume-btn="false"
inline-template
>

<div 
class="audio-player-container dark-player fixed-bottom center"
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
v-bind:class="[{ 'is-loading': srcLoading }]"
>

<div class="audio-title">
<span v-if="playlistLoaded && !srcLoading">[[ selectedAudio.creator_username ]] - [[ selectedAudio.name ]]</span>
<span v-else>&nbsp;</span>
</div>

<div class="audio-player-controls">

<div class="player-control playlist-toggle"> 
<a href="#" @click.prevent="togglePlaylist">
<transition name="fade-transition">
<i class="fas fa-chevron-up" v-if="playlistLoaded"></i>
</transition>
</a> 
</div>

<div class="player-control">

<a href="#" v-if="srcLoading || playlistLoading">
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

<div class="audio-player-time">

<div class="audio-player-time-current">[[ currentTime ]]</div>
<div class="audio-player-time-total">[[ durationTime ]]</div>

</div><!-- audio-player-time -->

</div><!-- progress-container -->

</div><!-- audio-player-controls -->

</div><!-- audio-player -->

<div class="audio-playlist">

<a
class="playlist-close"
@click.prevent="togglePlaylist(false)"
>
<i class="fas fa-times"></i>
</a>

<ul>

<li
v-for="(audio, index) in audios"
:key="audio.id"
>

<a 
class="audio-playlist-item"
@click.prevent="selectAudio(index)"
v-bind:class="[{ 'selected-audio': (index == audioIndex) }]"
v-if="(index != audioIndex)"
>
<span class="audio-creator">[[ audio.creator_username ]]</span> - 
<span class="audio-name">[[ audio.name ]]</span></a>

<div
class="audio-playlist-item selected-audio"
v-else
>

<span class="audio-creator">[[ audio.creator_username ]]</span> - 
<span class="audio-name">[[ audio.name ]]</span>
</div>

</li>

</ul>
</div><!-- audio-playlist -->

</div><!-- audio-player-container -->
</playlist-audio-player>
@endif
@endsection