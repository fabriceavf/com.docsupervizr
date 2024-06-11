@extends('layouts/contentLayoutMaster')

@section('title', 'Users')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->
    {{--@dd(Route::currentRouteName());--}}
    <script>

        window.routeData = {};
        // window.domaine = 'sgs';


        @if(Route::currentRouteName()=='Users_web_index')
            window.domaine = '{{ Helper::getMenuName() }}';
        window.routeData = {
            meta: {
                pageTitle: "Users",
                domain: '{{ Helper::getMenuName() }}',
                filter: [
                    {
                        type: "users",
                    },
                ],
            },
        };


        @elseif(Route::currentRouteName()=='Users_ONE_web_index')
            window.domaine = '{{ Helper::getMenuName() }}';
        window.routeData = {
            meta: {
                pageTitle: "ONE ",
                defaultEntite: "Agent",
                isOne: true,
                isPointage: true,
                domain: '{{ Helper::getMenuName() }}',
                filter: [
                    {
                        type: "one",
                    },
                ],
            },
        };

        @elseif(Route::currentRouteName()=='Users_VALIDER_web_index')
            window.domaine = '{{ Helper::getMenuName() }}';
        window.routeData = {
            meta: {
                pageTitle: "Employees ",
                defaultEntite: "Agent",
                hideCreate: true,
                domain: '{{ Helper::getMenuName() }}',
                isPointage: true,
                filter: [
                    {
                        type: "valider",
                    },
                    {
                        type: "agents",
                    },
                ],
            },
        };
        @elseif(Route::currentRouteName()=='Users_ENROLEMENTS_web_index')
            window.domaine = '{{ Helper::getMenuName() }}';
        window.routeData = {
            meta: {
                pageTitle: "Agents a valider ",
                domain: '{{ Helper::getMenuName() }}',
                defaultEntite: "Agent",
                filter: [
                    {
                        type: "a-valider",
                    },
                    {
                        type: "agents",
                    },
                ],
            },
        };

        @else
        @endif

    </script>
    @vite("resources/views/content/Users/main.js")
@endsection
