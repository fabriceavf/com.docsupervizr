@extends('layouts/contentLayoutMaster')

@section('title', 'Terminals')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

    @vite("resources/views/content/Terminals/main.js")
@endsection
