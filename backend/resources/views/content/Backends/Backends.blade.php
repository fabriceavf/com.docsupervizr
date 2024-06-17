@extends('layouts/contentLayoutMaster')

@section('title', 'Backends')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

    @vite("resources/views/content/Backends/main.js")
@endsection
