@extends('layouts/contentLayoutMaster')


@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

    @if(Route::currentRouteName()=='Activites_web_index')
        @section('title', 'Activites')
        <script>

            window.routeData = {
                meta: {
                    filter: [{
                        type: 'groupes',
                    },],
                },
            };
        </script>
    @elseif(Route::currentRouteName()=='Activites_besoins_web_index')
        @section('title', 'Besoins')
        <script>

            window.routeData = {
                meta: {
                    type: 'besoins',
                },
            };
        </script>
    @elseif(Route::currentRouteName()=='Activites_objectifs_web_index')
        @section('title', 'Objectifs')
        <script>

            window.routeData = {
                meta: {
                    hideCreate: true,
                    type: 'objectifs',
                },
            };
        </script>
    @elseif(Route::currentRouteName()=='Activites_deleguer_web_index')
        @section('title', 'Deleguer')
        <script>

            window.routeData = {
                meta: {
                    hideCreate: true,
                    filter: [{
                        type: 'deleguer',
                    },],
                },
            };
        </script>
    @elseif(Route::currentRouteName()=='Activites_recu_web_index')
        @section('title', 'Recu')
        <script>

            window.routeData = {
                meta: {
                    hideCreate: true,
                    filter: [{
                        type: 'recu',
                    },],
                },
            };
        </script>
    @endif
    @vite("resources/views/content/Activites/main.js")
@endsection
