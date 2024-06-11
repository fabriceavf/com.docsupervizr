@extends('layouts/contentLayoutMaster')

@section('title', 'Pointages')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

    <script>

        let routeData = {};
    </script>
    @vite("resources/views/content/Pointages/main.js")
@endsection
