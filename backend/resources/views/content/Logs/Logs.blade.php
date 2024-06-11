@extends('layouts/contentLayoutMaster')

@section('title', 'Logs')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    <script>

        window.routeData = {
            meta: {
                hideCreate: true
            },
        };
    </script>
    @vite('resources/views/content/Logs/main.js')
@endsection
