@php use App\Models\Direction; @endphp
@php use App\Models\Zone;
$zonesGet = Zone::whereIn('id', function ($query) {
        return $query
            ->select('zone_id')
        ->whereNull('userszones.deleted_at')
            ->from('userszones')
            ->where('user_id', Auth::id());
    })
        ->get();
        // dd($zonesGet);
@endphp
@extends('layouts/contentLayoutMaster')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    @if (Route::currentRouteName() == 'Agentsrapports_web_index')
        @section('title', 'Pointages Agents')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    directionsGet:@json(Direction::all()),
                    filter: [
                        {
                            type: "valider",
                        },
                    ],
                    zonesGet: @json($zonesGet),
                    statsType: 'Pointages'
                },
            };
        </script>
    @elseif(Route::currentRouteName() == 'Vacation_agents_web_index')
        @section('title', 'Vacation Agents')
        <script>
            window.domaine = '{{ Helper::getMenuName() }}';
            window.routeData = {
                meta: {
                    directionsGet:@json(Direction::all()),
                    filter: [
                        {
                            type: "valider",
                        },
                    ],
                    zonesGet: @json($zonesGet),
                    statsType: 'Vacations'
                },
            };
        </script>
    @else
    @endif
    @vite('resources/views/content/Agentsrapports/main.js')
@endsection
