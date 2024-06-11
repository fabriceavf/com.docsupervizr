@php use App\Models\Typestache;
@endphp

@extends('layouts/contentLayoutMaster')

@section('title', 'Taches')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    <script>
        window.routeData = {
            meta: {
                typetachesGet: @json(Typestache::all()),
            },
        };
    </script>
    @vite("resources/views/content/Taches/main.js")
@endsection
