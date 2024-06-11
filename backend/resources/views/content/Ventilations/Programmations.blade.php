@extends('layouts/contentLayoutMaster')



@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->


    @if(Route::currentRouteName()=='Programmations_web_index')
        @section('title', 'Programmations')
        <script>

            window.routeData = {
                meta: {
                    isProgrammations: true

                },
            };    </script>

    @elseif(Route::currentRouteName()=='Programmations_LISTINGS_web_index')
        @section('title', 'LISTINGS')
        <script>

            window.routeData = {
                meta: {
                    isListings: true
                },
            };
        </script>

    @else
    @endif
    @vite("resources/views/content/Programmations/main.js")
@endsection
