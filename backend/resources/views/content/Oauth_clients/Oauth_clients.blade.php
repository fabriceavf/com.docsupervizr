@extends('layouts/contentLayoutMaster')

@section('title', 'Oauth_clients')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

    @vite("resources/views/content/Oauth_clients/main.js")
@endsection
