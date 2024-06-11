@extends('layouts/contentLayoutMaster')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->


    @if (Route::currentRouteName() == 'Imports_web_index')
        @section('title', 'Imports agents')
        <script>
            window.domain = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    domain: '{{ Helper::getMenuName() }}',
                },
            };
        </script>
        @vite('resources/views/content/Imports/main.js')
    @elseif(Route::currentRouteName() == 'Imports_postes_web_index')
        @section('title', 'Imports postes')
        <script>
            window.routeData = {
                meta: {
                    ispostes: true,
                    domain: '{{ Helper::getMenuName() }}',
                },
            };
        </script>
        @vite('resources/views/content/Imports/main.js')
    @else
    @endif

@endsection
