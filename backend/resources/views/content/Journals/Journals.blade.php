@php use App\Models\Direction; @endphp

@extends('layouts/contentLayoutMaster')

@section('title', 'Pointages')

@section('content')
    @javascript('params', request()->all())
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    <script>
        window.domaine = '{{ Helper::getMenuName() }}';
        window.routeData = {
            meta: {
                hideCreate: true,
                directionsGet:@json(Direction::all()),
                domain: '{{ Helper::getMenuName() }}'

            },
        };
    </script>
    @vite('resources/views/content/Journals/main.js')
@endsection
