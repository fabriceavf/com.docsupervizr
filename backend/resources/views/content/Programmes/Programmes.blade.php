@extends('layouts/contentLayoutMaster')


@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

    @if(Route::currentRouteName()=='Programmes_PRESENCES_web_index')
        @section('title', 'Listes de presence')
        <script>

            window.routeData = {
                meta: {
                    filter: [
                        {
                            type: "presences",
                        },
                    ],

                },
            };
        </script>

    @elseif(Route::currentRouteName()=='Programmes_ABSCENCES_web_index')
        @section('title', "Listes d'abscence")
        <script>

            window.routeData = {
                meta: {
                    filter: [
                        {
                            type: "abscences",
                        },
                    ],

                },
            };
        </script>
    @elseif(Route::currentRouteName()=='Programmes_ABSCENCES_web_index')
        @section('title', "Listes d'abscence")
        <script>

            window.routeData = {
                meta: {
                    filter: [
                        {
                            type: "abscences",
                        },
                    ],

                },
            };
        </script>

    @elseif(Route::currentRouteName()=='Programmes_EXCEPTIONS_web_index')
        @section('title', "Listes des exceptions")
        <script>

            window.routeData = {
                meta: {
                    filter: [
                        {
                            type: "exceptions",
                        },
                    ],

                },
            };
        </script>

    @else
    @endif
    @vite("resources/views/content/Programmes/main.js")
@endsection
