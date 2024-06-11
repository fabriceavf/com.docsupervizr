@extends('layouts/contentLayoutMaster')

@section('title', 'Alarms')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    <script>

        window.routeData = {
            meta: {
                // hideCreate: true
            },
        };
    </script>
    @vite('resources/views/content/Alarms/main.js')
@endsection
