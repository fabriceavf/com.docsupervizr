@extends('layouts/contentLayoutMaster')

@section('title', 'Listings jours')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->


    @vite("resources/views/content/Listingsjours/main.js")
    {{--    @if(Route::currentRouteName()=='Listingsjours_LISTING-MANUEL_web_index')--}}
    {{--        <script>
import CustomSelect from "@/components/CustomSelect.vue";--}}
    {{--            window.routeData = {--}}
    {{--                meta: {--}}
    {{--                    pageTitle: "Listings Manuel",--}}
    {{--                    listing: "manuel",--}}
    {{--                    filter: [--}}
    {{--                        {--}}
    {{--                            type: "manuel",--}}
    {{--                        },--}}
    {{--                    ],--}}
    {{--                },--}}
    {{--            };    </script>--}}
    {{--        @vite("resources/views/content/Listingsjours/main.js")--}}

    {{--    @elseif(Route::currentRouteName()=='Listingsjours_LISTING-AUTOMATIQUE_web_index')--}}
    {{--        <script>
import CustomSelect from "@/components/CustomSelect.vue";--}}
    {{--            window.routeData = {--}}
    {{--                meta: {--}}
    {{--                    pageTitle: "Listings automatique",--}}
    {{--                    listing: "automatique",--}}
    {{--                    filter: [--}}
    {{--                        {--}}
    {{--                            type: "automatique",--}}
    {{--                        },--}}
    {{--                    ],--}}
    {{--                },--}}
    {{--            };--}}
    {{--        </script>--}}
    {{--        @vite("resources/views/content/Listingsjours/main.js")--}}

    {{--    @else--}}
    {{--    @endif--}}
@endsection
