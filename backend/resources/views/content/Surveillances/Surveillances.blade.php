@extends('layouts/contentLayoutMaster')

@section('title', 'Surveillances')

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
    @vite('resources/views/content/Surveillances/main.js')
@endsection
