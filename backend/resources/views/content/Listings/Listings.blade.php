@extends('layouts/contentLayoutMaster')

@section('title', 'Tutoriel Video')

@section('content')
    @if (Helper::getMenuName() == 'sgs')
        <div class="container">

            <div class="row">
                <div class="col-sm-6">
                    <h2>Validation des listings</h2>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/pv4EzfBFiaA?si=hzEDsIEpbIDsETId"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="col-sm-6">
                    <h2>Affectations des agents au postes</h2>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/8L9GVgtiUT0?si=xmgZoFSCCnEIb55i"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>

    @endif

    <script>
        window.domaine = '{{ Helper::getMenuName() }}';
        window.routeData = {
            meta: {
                hideCreate: true,

            },
        };
    </script>
    @vite("resources/views/content/Listings/main.js")
@endsection

