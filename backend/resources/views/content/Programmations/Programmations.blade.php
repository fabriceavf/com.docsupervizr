@php use App\Models\Zone;

$zonesGet = Zone::whereIn('id', function ($query) {
        return $query
            ->select('zone_id')
            ->from('userszones')
            ->whereNull('userszones.deleted_at')
            ->where('user_id', Auth::id());
    })
        ->get();
$typeHeures = \App\Models\Typesheure::all()
@endphp

@extends('layouts/contentLayoutMaster')



@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->


    @if (Route::currentRouteName() == 'Programmations_web_index')
        @section('title', 'Programmations')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    isProgrammations: true,
                    isProgrammationsvalid: true,
                    filter: [{
                        type: 'programmations',
                    },
                        {
                            type: "valider",
                        },
                        {
                            type: "agents",
                        }
                    ],
                },
            };
        </script>
    @elseif(Route::currentRouteName() == 'Programmations_Rapports_web_index')
        @section('title', 'Rapports')
        <script>
            window.routeData = {
                meta: {
                    isRapports: true,
                    filter: [{
                        type: 'rapports',
                    },],
                },

            };
        </script>
    @elseif(Route::currentRouteName() == 'Programmations_LISTINGS_web_index')
        @section('title', 'LISTINGS')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    isListings: true,

                    zonesGet: @json($zonesGet),
                    typeHeures: @json($typeHeures),
                    validation: true,
                    filter: [{
                        type: 'listings',
                    },
                    ],
                },

            };
        </script>
    @elseif(Route::currentRouteName() == 'Programmations_LISTINGS_Valider1_web_index')
        @section('title', 'LISTINGS VALIDATION1')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    validation1: true,
                    isListings: true,

                    zonesGet: @json($zonesGet),
                    typeHeures: @json($typeHeures),
                    isListingvalidations: true,
                    filter: [{
                        type: 'listings',
                    },
                    ],
                },

            };
        </script>
    @elseif(Route::currentRouteName() == 'Programmations_LISTINGS_Valider2_web_index')
        @section('title', 'LISTINGS VALIDATION2')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    validation2: true,
                    isListings: true,

                    zonesGet: @json($zonesGet),
                    typeHeures: @json($typeHeures),
                    isListingvalidations: true,
                    filter: [{
                        type: 'listings',
                    },
                    ],
                },

            };
        </script>
    @elseif(Route::currentRouteName() == 'Programmations_LISTINGS_Postes_web_index')
        @section('title', 'LISTINGS Par poste')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    isListingPostes: true,
                    filter: [{
                        type: 'listings-postes'
                    },
                        {
                            type: "valider",
                        },
                        {
                            type: "agents",
                        },
                    ],
                },


            };
        </script>
    @else
    @endif
    @vite('resources/views/content/Programmations/main.js')
@endsection
