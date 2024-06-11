@extends('layouts/contentLayoutMaster')

@section('title', 'Contrats des clients')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    <script>
        window.routeData = {
            meta: {
                postesimporter: true,
            },
        };
    </script>
    @vite("resources/views/content/Contratsclients/main.js")
@endsection
