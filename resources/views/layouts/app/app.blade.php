<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.app.appHead')
<body class="font-sans antialiased">
{{--    NAVIGATION--}}
    @include('layouts.app.appNavigation')

    {{--    CONTENT--}}
    <div class="container is-fluid">
        @yield('content')
    </div>

{{--    SCRIPTS--}}
    @include('layouts.app.appScripts')
</body>
</html>
