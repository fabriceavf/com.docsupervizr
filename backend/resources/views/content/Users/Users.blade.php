@php use App\Models\Direction; @endphp
@php use App\Models\Zone;
use App\Models\Typeseffectif;
$zonesGet = Zone::whereIn('id', function ($query) {
        return $query
            ->select('zone_id')
        ->whereNull('userszones.deleted_at')
            ->from('userszones')
            ->where('user_id', Auth::id());
    })
        ->get();

$champsHides=[];
foreach(DB::table('typeseffectifs')->get() as $data){
    $champsHide=explode(',',$data->champHide);
    if(!empty($data->champsHide)){
        $champsHide=[];
    }
    $champsHides[$data->id]=$champsHide;
};
// Tableau pour stocker toutes les valeurs
$valeurs = [];

// Fusionner tous les sous-tableaux en un seul
foreach ($champsHides as $sousTableau) {
    $valeurs = array_merge($valeurs, $sousTableau);
}
$champsHides=$valeurs;
// dd($champsHides);
@endphp

@php


    @endphp
@extends('layouts/contentLayoutMaster')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    {{-- @dd(Route::currentRouteName()); --}}


    @if (Route::currentRouteName() == 'Users_web_index')
        @section('title', 'Utilisateurs')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    pageTitle: "Users",
                    typesGet: @json(Typeseffectif::all()),
                    directionsGet:@json(Direction::all()),
                    domain: '{{ Helper::getMenuName() }}',
                    domain: '{{ Helper::getMenuName() }}',
                    filter: [{
                        type: "users",
                    },],
                },
            };
        </script>
        @vite('resources/views/content/Users/main.js')
    @elseif(Route::currentRouteName() == 'Users_SU_web_index')
        @section('title', 'SU')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    pageTitle: "SU",
                    type: 'SU',
                    typesGet: @json(Typeseffectif::all()),
                    directionsGet:@json(Direction::all()),
                    domain: '{{ Helper::getMenuName() }}',
                    filter: [{
                        type: "su",
                    },],
                },
            };
        </script>
        @vite('resources/views/content/Users/main.js')
    @elseif(Route::currentRouteName() == 'Users_ONE_web_index')
        @section('title', 'ONE')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    pageTitle: "ONE ",
                    defaultEntite: "Agent",
                    isOne: true,
                    typesGet: @json(Typeseffectif::all()),
                    directionsGet:@json(Direction::all()),
                    zonesGet: @json($zonesGet),
                    isPointage: true,
                    domain: '{{ Helper::getMenuName() }}',
                    filter: [{
                        type: "one",
                    },],
                },
            };
        </script>
        @vite('resources/views/content/Agents/main.js')
    @elseif(Route::currentRouteName() == 'Users_VALIDER_web_index')
        @section('title', 'effectifs')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    pageTitle: "Employees ",
                    defaultEntite: "Agent",
                    isAgent: true,
                    typesGet: @json(Typeseffectif::all()),
                    directionsGet:@json(Direction::all()),
                    zonesGet: @json($zonesGet),
                    domain: '{{ Helper::getMenuName() }}',
                    champsHide: '@json($champsHides)',
                    filter: [{
                        type: "valider",
                    },
                        {
                            type: "agents",
                        },
                    ],
                },
            };
        </script>
        @vite('resources/views/content/Agents/main.js')
    @elseif(Route::currentRouteName() == 'Users_ENROLEMENTS_web_index')
        @section('title', 'Enrolements')
        <script>

            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    pageTitle: "Agents a valider ",
                    defaultEntite: "Agent",
                    typesGet: @json(Typeseffectif::all()),
                    directionsGet:@json(Direction::all()),
                    domain: '{{ Helper::getMenuName() }}',
                    filter: [{
                        type: "a-valider",
                    },
                        {
                            type: "agents",
                        },
                    ],
                },
            };
        </script>
        @vite('resources/views/content/Agents/main.js')
    @else
    @endif

@endsection
