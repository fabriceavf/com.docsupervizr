@extends('layouts/contentLayoutMaster')


@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

    @if(Route::currentRouteName()=='Modelslistings_web_index')
        @section('title', 'Planifications')
        <script>

            window.routeData = {
                meta: {
                    isProgrammations: true,
                },
            };
        </script>

    @else
        @section('title', 'Rapports')
        <script>

            window.routeData = {
                meta: {
                    isProgrammations: true,
                    isRapport: true
                },
            };
        </script>
    @endif
    @vite("resources/views/content/Modelslistings/main.js")
@endsection
