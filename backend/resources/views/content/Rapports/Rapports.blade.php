@php use App\Models\Direction; @endphp
@php use App\Models\Zone;
    use Illuminate\Http\Request;
    use Carbon\CarbonImmutable;
    use Illuminate\Support\Carbon;
$zonesGet = Zone::whereIn('id', function ($query) {
        return $query
            ->select('zone_id')
        ->whereNull('userszones.deleted_at')
            ->from('userszones')
            ->where('user_id', Auth::id());
    })
        ->get();
    // Obtenez la date actuelle
    $dateActuelle = Carbon::now();

        $month =  $dateActuelle->format('Y-m');
        // dd($month);
    try {
        $request = request();
        if ($request->query('month')) {
    $month = $request->query('month');
        };
    } catch (\Throwable $th) {
        //throw $th;
    }
@endphp

@extends('layouts/contentLayoutMaster')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

    @if (Route::currentRouteName() == 'Rapports_web_index')
        @section('title', 'Rapport Pointages')
        <script>

            window.routeData = {
                meta: {
                    filter: [
                        {
                            type: "valider",
                        },
                    ],
                    directionsGet:@json(Direction::all()),
                    zonesGet: @json($zonesGet),
                    months: @json($month),
                    statsType: 'Pointages'
                },
            };
        </script>
    @elseif(Route::currentRouteName() == 'Vacation_postes_web_index')
        @section('title', 'Rapport Vacation')
        <script>

            window.routeData = {
                meta: {
                    filter: [
                        {
                            type: "valider",
                        },
                    ],
                    directionsGet:@json(Direction::all()),
                    zonesGet: @json($zonesGet),
                    months: @json($month),
                    statsType: 'Vacations'
                },
            };
        </script>
    @elseif(Route::currentRouteName() == 'Vacation_postes_web_index')
        @section('title', 'Rapport Vacation')
        <script>

            window.routeData = {
                meta: {
                    filter: [
                        {
                            type: "valider",
                        },
                    ],
                    directionsGet:@json(Direction::all()),
                    zonesGet: @json($zonesGet),
                    months: @json($month),
                    statsType: 'Retard'
                },
            };
        </script>
    @else
    @endif
    @vite("resources/views/content/Rapports/main.js")
@endsection
