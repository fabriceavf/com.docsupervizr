@extends('layouts/contentLayoutMaster')
@php use App\Models\Zone;


$typeHeures = \App\Models\Typesheure::all();

@endphp
@section('title', 'Ventilations')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    <script>

        window.routeData = {
            meta: {
                filter: [
                    {
                        type: "valider",
                    },
                    {
                        type: "agents",
                    },
                ],
                typeHeures: @json($typeHeures),
            },
        };
    </script>
    @vite("resources/views/content/Ventilations/main.js")
@endsection
