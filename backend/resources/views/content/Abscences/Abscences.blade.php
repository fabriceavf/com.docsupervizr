@extends('layouts/contentLayoutMaster')

@section('title', 'Abscences')

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
            },
        };
    </script>
    @vite("resources/views/content/Abscences/main.js")
@endsection
