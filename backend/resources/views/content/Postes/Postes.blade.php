@php use App\Models\Zone;
use App\Models\Typesposte;

$zonesGet = Zone::whereIn('id', function ($query) {
        return $query
            ->select('zone_id')
            ->from('userszones')
            ->whereNull('userszones.deleted_at')
            ->where('user_id', Auth::id());
    })
        ->get()
@endphp

@extends('layouts/contentLayoutMaster')



@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    @if (Route::currentRouteName() == 'Postes_web_index')
        @section('title', 'Postes')
        <script>
            window.routeData = {
                meta: {
                    hideCreate: true,
                    zonesGet: @json($zonesGet),
                    typesGet: @json(Typesposte::all()),
                    filter: [{
                        type: "importer",
                    },
                    ],
                },
            };
        </script>
    @elseif(Route::currentRouteName() == 'Postes_non_importer_web_index')
        @section('title', 'Postes internes')
        <script>
            window.routeData = {
                meta: {
                    typesGet: @json(Typesposte::all()),
                    zonesGet: @json($zonesGet),
                    nonimporter: true,
                    filter: [{
                        type: "nonimporter",
                    },
                    ],
                },
            };
        </script>
    @elseif(Route::currentRouteName() == 'Postes_operationnel_web_index')
        @section('title', 'Postes opération')
        <script>
            window.routeData = {
                meta: {
                    zonesGet: @json($zonesGet),
                    typesGet: @json(Typesposte::all()),
                    operationnel: true,
                    filter: [{
                        type: "operationnel",
                    },
                    ],
                },
            };
        </script>
    @elseif(Route::currentRouteName() == 'Postes_Baladeur_web_index')
        @section('title', 'Postes baladeur')
        <script>
            window.routeData = {
                meta: {
                    zonesGet: @json($zonesGet),
                    typesGet: @json(Typesposte::all()),
                    baladeur: true,
                    filter: [{
                        type: "baladeur",
                    },
                    ],
                },
            };
        </script>
    @elseif(Route::currentRouteName() == 'Postes_surete_aeriene_web_index')
        @section('title', 'Postes surete aeriene')
        <script>
            window.routeData = {
                meta: {
                    zonesGet: @json($zonesGet),
                    typesGet: @json(Typesposte::all()),
                    surete_aeriene: true,
                    filter: [{
                        type: "surete_aeriene",
                    },
                    ],
                },
            };
        </script>
    @else
    @endif
    @vite('resources/views/content/Postes/main.js')
@endsection
