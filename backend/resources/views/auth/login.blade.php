@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
    <style>
        .centre {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
        }

        #element {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')
    <div class=" centre">
        <div id="element">
            <div id="app"></div>

        </div>
    </div>

    @vite("resources/views/content/Logins/main.js")
@endsection
