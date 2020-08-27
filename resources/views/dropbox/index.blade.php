@extends('layouts.base')

@section('page_title', __('messages.page_dropbox_index_title'))

@section('content')
@php
// $dbxFileDeleteUrl = route('api.dbx.delete_file');
$dbxSharedLinkUrl = route('api.dbx.shared_link');
$dbxUploadUrl = route('api.dbx.upload_file');
$dbxFilesUrl = route('api.dbx.user_files');
@endphp

<div class="columns is-multiline">
<div class="column is-6 is-offset-3">
@csrf

<dbx
shared-link-url="{{ $dbxSharedLinkUrl }}"
:init-is-admin="true"
inline-template
>

<div class="dbx-container">

<div class="dbx-shared-link" style="margin-bottom: 30px;">

<label class="label" for="audio-url">
{{ __('messages.label_dbx_audio_shared_link') }}
</label>
<input id="audio-url" class="input" ref="audio-url" name="audio-url" v-model="sharedLink" readonly>

</div>

<div class="dbx-file-uploader" style="margin-bottom: 30px;">

<dbx-audio-file-uploader
ref="dbx-audio-file-uploader"
init-upload-url="{{ $dbxUploadUrl }}"
:parent-processing="processing"
@change-file="onChangeDbxFile"
@upload-dbx-file="onUploadDbxFile($event.path_lower)"
>

<template slot="label-select-file">
{{ __('messages.label_select_audio_file') }}
</template>

<template slot="label-submit">
{{ __('messages.label_submit_file') }}
</template>

</dbx-audio-file-uploader>

</div>

<div class="dbx-user-files">

<dbx-user-files
ref="dbx-user-files"
files-url="{{ $dbxFilesUrl }}"
:parent-processing="processing"
:init-is-admin="isAdmin"
@select-dbx-file="getSharedLink($event)"
@delete-dbx-file="onDeleteDbxFile"
inline-template
>

<div>

<button
class="button is-primary"
v-bind:class="[{ 'is-loading': processing }]"
@click.prevent="getFiles"
>
{{ __('messages.msg_get_user_dbx_files') }}
</button>

<ul
class="files"
v-cloak
>

<dbx-file
v-for="(file, index) in sortedFiles"
:key="file.id"
:init-file="file"
:init-is-admin="isAdmin"
init-delete-url=""
@select-dbx-file="selectDbxFile($event.path_lower)"
@delete-dbx-file="onDeleteDbxFile(index)"
inline-template
>

<transition name="fade-transition" v-on:after-enter="isVisible = true" v-on:after-leave="remove">

<li v-show="isVisible"> 

<ajax-delete
v-if="isAdmin"
delete-confirm-id="delete-dbx-file"
:delete-url="deleteUrl"
:init-data="{'dbx_path': file.path_lower}"
@ajax-success="isVisible = false"
inline-template
>

<a 
class="delete" 
href="#"
@click.prevent="confirmDelete"
>
</a>

</ajax-delete>

<a 
href="#"
@click.prevent="selectDbxFile(file)"
>
[[ file.name ]]
</a>

</li>

</transition>

</dbx-file>

</ul>

</div>

</dbx-user-files>

</div>

</div><!-- dbx-container -->

</dbx>

</div>
</div>
@endsection
