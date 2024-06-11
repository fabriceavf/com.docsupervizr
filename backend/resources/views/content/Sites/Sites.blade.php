@php
    use App\Models\Typessite;
@endphp

@extends('layouts/contentLayoutMaster')

@section('title', 'Sites')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    <script>
        window.domaine = '{{ Helper::getMenuName() }}';
        window.routeData = {
            meta: {
                typesGet: @json(Typessite::all()),
                // Key: {{ env('GOOGLE_MAP_KEY') }},
            },
        };
    </script>
    @vite("resources/views/content/Sites/main.js")
@endsection
