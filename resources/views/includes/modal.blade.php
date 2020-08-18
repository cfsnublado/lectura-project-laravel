<{{ $modalName ?? 'modal' }} 
@yield('modal_extra')
v-cloak 
inline-template
init-id="{{ $modalId ?? 'modal' }}"
>

<transition 
name="fade-transition" 
v-on:after-enter="isOpen = true" 
v-on:after-leave="isOpen = false"
>

<div 
id="{{ $modalId ?? 'modal' }}"
class="modal @yield('modal_classes')"
v-bind:class="[{ 'is-active': isOpen }]"
@click.stop
>

<div class="modal-background" @click="close"></div>

<div class="modal-content">
<div class="box">

@section('modal_content')

<header class="modal-header">

@yield('modal_header')

</header>

<section class="modal-body">

@yield('modal_body')

</section>

<footer class="modal-footer">

@yield('modal_footer')

</footer>

@show

</div>
</div>

</div>

</transition>

</{{ $modalName ?? 'modal' }}>