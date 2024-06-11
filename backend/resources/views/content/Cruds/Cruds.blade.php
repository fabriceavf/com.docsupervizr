@extends('layouts/contentLayoutMaster')

@section('title', 'Activités recentes')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    <script>

        window.routeData = {
            meta: {
                filter: [
                    {
                        type: "users",
                    },
                    // {
                    //     type: "su",
                    // },
                ],
            },
        };
    </script>
    @vite("resources/views/content/Cruds/main.js")
@endsection
