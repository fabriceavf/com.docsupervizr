@extends('layouts/contentLayoutMaster')


@section('content')
    <div>

        @php
            $i=max([count($data['allChamps']),count($data['allFonctions'])]);
            $champs=$data['allChamps'];
            $fonctions=$data['allFonctions'];
        @endphp
        <div class="card">
            <div class="card-header">
                {{$data['name']}}
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Attribut</th>
                        <th scope="col">Fonction</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(range(0, $i) as $count)
                        <tr>
                            <td> @if(array_key_exists($count, $champs))
                                    {{$champs[$count]}}
                                @endif</td>
                            <td>@if(array_key_exists($count, $fonctions))
                                    {{$fonctions[$count]}}
                                @endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
