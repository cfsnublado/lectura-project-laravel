@if (count($messages))
@foreach ($messages as $message)
<alert-message 
message-type="{{ $message['level'] }}"
message-text="{!! $message['message'] !!}"
:init-auto-close="true"
>
</alert-message>
@endforeach
@endif