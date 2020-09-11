@extends('layouts.base')

@section('page_title', __('messages.page_dropbox_index_title'))

@section('content')
@php
$dbxFileDeleteUrl = route('api.dbx.delete_file');
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

<div class="dbx-shared-link">

<label class="label" for="audio-url">
{{ __('messages.label_dbx_shared_link') }}
</label>
<input id="audio-url" class="input" ref="audio-url" name="audio-url" v-model="sharedLink" readonly>

</div>

<div class="dbx-file-uploader">

<dbx-audio-file-uploader
ref="dbx-audio-file-uploader"
init-upload-url="{{ $dbxUploadUrl }}"
:parent-processing="processing"
@change-file="onChangeDbxFile"
@upload-dbx-file="onUploadDbxFile($event.path_lower)"
>

<template slot="label-select-file">
{{ __('messages.label_select_file') }}
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
{{ __('messages.label_get_dbx_user_files') }}
</button>

<div 
style="margin-top: 20px;"
v-if="!processing && files && files.length == 0" 
v-cloak
>
{{ __('messages.msg_no_dbx_user_files') }} <b>{{ Auth::user()->username }}</b>.
</div>

<ul
class="dbx-files"
v-cloak
>

<dbx-file
v-for="(file, index) in sortedFiles"
:key="file.id"
:init-file="file"
:init-is-admin="isAdmin"
init-delete-url="{{ $dbxFileDeleteUrl }}"
@select-dbx-file="selectDbxFile($event.path_lower)"
@delete-dbx-file="onDeleteDbxFile(index)"
inline-template
>

<transition name="fade-transition" v-on:after-enter="isVisible = true" v-on:after-leave="remove">

<li class="dbx-file"
v-show="isVisible"
> 

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
class="dbx-filename"
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

@section('modal')
@include(
'dropbox/includes/dbx_file_delete_modal',
['modalId' => 'delete-dbx-file', 'modalName' => 'confirmation-modal']
)
@endsection
