@extends('layouts/contentLayoutMaster')

@section('title', 'Configurations')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    <script>
        window.routeData = {
            meta: {
                domain: '{{ Helper::getMenuName() }}',
            }
        };
    </script>
    @vite('resources/views/content/Configurations/main.js')
@endsection
