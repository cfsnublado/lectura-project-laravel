@extends('includes/modal')

@section('modal_classes') confirmation-modal @endsection

@section('modal_footer')

<span class="confirmation-buttons">

<a 
href="#"
id="@yield('cancel_id')"
class="button"
@click.prevent="close"
>
{{ __('messages.label_no') }}
</a>

<button
id="@yield('ok_id')" 
class="button is-danger"
@click.prevent="confirm"
>
{{ __('messages.label_yes') }}
</button>

</span>

@endsection