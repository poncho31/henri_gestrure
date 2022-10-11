{{--        SCRIPTS--}}

<script src="{{asset('js/app.js')}}"></script>

@yield('js')


{{--    EVENT RECEIVE--}}
<script>
    $(document).ready(function(){
        console.log("Window general",window.general)
        window.general.EventReceive('{{ Auth::user()->id??null }}', 'userEvent')
    })
</script>

@stack('js')


@livewireScripts
