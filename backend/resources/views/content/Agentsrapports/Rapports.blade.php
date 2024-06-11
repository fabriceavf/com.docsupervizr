@extends('layouts/contentLayoutMaster')

@section('title', 'Vacation par agents')

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
    @vite("resources/views/content/Agentsrapports/main.js")
@endsection
