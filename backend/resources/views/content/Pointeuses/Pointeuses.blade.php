@php use App\Models\Zone;
$zonesGet = Zone::whereIn('id', function ($query) {
        return $query
            ->select('zone_id')
        ->whereNull('userszones.deleted_at')
            ->from('userszones')
            ->where('user_id', Auth::id());
    })
        ->get();
@endphp

@extends('layouts/contentLayoutMaster')

@section('title', 'Pointeuses')

@section('content')
    <script>
        window.domaine = '{{ Helper::getMenuName() }}';
        window.routeData = {
            meta: {
                pageTitle: "Users",
                domain: '{{ Helper::getMenuName() }}',
                zonesGet: @json($zonesGet),
            },
        };
    </script>
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

    @vite("resources/views/content/Pointeuses/main.js")
@endsection
