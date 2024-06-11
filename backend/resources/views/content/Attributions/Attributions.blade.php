@php
    $structreJson = file_get_contents(base_path('resources/data/database-structure/structure.json'));
    $structreDatas = json_decode($structreJson);
    $fonctionalitesTotal=collect($structreDatas)->pluck('fonctionalites')->collapse()->count();
    $fonctionalites=collect($structreDatas)->groupBy('table');




    $createActifsDto=\App\Manager\Actifs\ActifsCreateDataManager::getDtoFromArray([
        'libelle'=>"test",
        'code'=>"1234",
        'created_at'=>now(),
        ]);
     $createActifsDto=\App\Manager\Actifs\ActifsCreateDataManager::setDbHost($createActifsDto,env('DB_HOST'));
    $createActifsDto=\App\Manager\Actifs\ActifsCreateDataManager::setDbName($createActifsDto,env('DB_DATABASE'));
    $createActifsDto=\App\Manager\Actifs\ActifsCreateDataManager::setDbUser($createActifsDto,env('DB_USERNAME'));
    $createActifsDto=\App\Manager\Actifs\ActifsCreateDataManager::setDbPass($createActifsDto,env('DB_PASSWORD'));
    $createActifsDto=\App\Manager\Actifs\ActifsCreateDataManager::exec($createActifsDto);
    dump('$createActifsDto',$createActifsDto);

    $updateActifsDto=\App\Manager\Actifs\ActifsUpdateDataManager::getDto();
    $updateActifsDto->Id=70;
    $updateActifsDto->Code="manger123";
    $updateActifsDto->CreatedAt=now();
    $updateActifsDto=\App\Manager\Actifs\ActifsUpdateDataManager::setDbHost($updateActifsDto,env('DB_HOST'));
    $updateActifsDto=\App\Manager\Actifs\ActifsUpdateDataManager::setDbName($updateActifsDto,env('DB_DATABASE'));
    $updateActifsDto=\App\Manager\Actifs\ActifsUpdateDataManager::setDbUser($updateActifsDto,env('DB_USERNAME'));
    $updateActifsDto=\App\Manager\Actifs\ActifsUpdateDataManager::setDbPass($updateActifsDto,env('DB_PASSWORD'));
    $updateActifsDto=\App\Manager\Actifs\ActifsUpdateDataManager::exec($updateActifsDto);
    dump('$updateActifsDto',$updateActifsDto);

    $deleteActifsDto=\App\Manager\Actifs\ActifsDeleteDataManager::getDto();
    $deleteActifsDto->Id=70;
    $deleteActifsDto->Code="manger123";
    $deleteActifsDto->CreatedAt=now();
    $deleteActifsDto=\App\Manager\Actifs\ActifsDeleteDataManager::setDbHost($deleteActifsDto,env('DB_HOST'));
    $deleteActifsDto=\App\Manager\Actifs\ActifsDeleteDataManager::setDbName($deleteActifsDto,env('DB_DATABASE'));
    $deleteActifsDto=\App\Manager\Actifs\ActifsDeleteDataManager::setDbUser($deleteActifsDto,env('DB_USERNAME'));
    $deleteActifsDto=\App\Manager\Actifs\ActifsDeleteDataManager::setDbPass($deleteActifsDto,env('DB_PASSWORD'));
    $deleteActifsDto=\App\Manager\Actifs\ActifsDeleteDataManager::exec($deleteActifsDto);
    dump('$deleteActifsDto',$deleteActifsDto);


     dd('terminer');




@endphp

@section('panels/styles')


@endsection

@extends('layouts/fullLayoutMaster')
@section('content')
    @json(['tes'=>'test'],true)
    <style>
        .functionButton {
            margin: 2px;
        }

        .functionBlockParents {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-around;
        }

        .functionBlockParents {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-around;
        }

        .functionBlock {
            padding: 10px;
            width: 100%;
            border: 1px solid #aaa;
            border-radius: 5px;
            page-break-before: always;

        }

        .functionBlock1 {
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            page-break-before: always;

        }
    </style>
    <div class="container-fluid">
        <div class="row" style="padding: 50px;">

            <div class="col-sm-12">
                <div class="card-header">
                    <h2>Listes des {{$fonctionalitesTotal}} fonctionalites regrouper par modules</h2>
                </div>

                <div class="card">

                    <div class="card-body">
                        <div class="functionBlockParents">
                            @foreach($fonctionalites as $module=>$usecases)
                                @php
                                    $local_fonctionalites=collect($usecases)->pluck('fonctionalites')->collapse();
                                @endphp
                                <div class="functionBlock1" style="">
                                    <h5>Modules {{$module}} : {{$local_fonctionalites->count()}} fonctionalités </h5>
                                    @foreach($local_fonctionalites as $key=>$usecase)
                                        <button type="button" class="functionButton btn btn-outline-secondary btn-sm">
                                            {{$key+1}}: {{$usecase}}
                                        </button>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding: 50px;">
            @foreach($structreDatas as $key=>$structreData)

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Class {{$structreData->class}} {{$key}}</h2>
                        </div>

                        <div class="card-body">
                            <h3>Description </h3>
                            <p>
                                {{$structreData->description}}  </p>
                            <p>
                                <span style="color:red">NB:</span> Pour rappel il est develloper pour
                                fonctionner uniquement avec les bases de donnees MYSQL ,SQLITE
                            </p>
                            {{--                                <h3>Parametres</h3>--}}
                            {{--                                <p>--}}
                            {{--                                    Cette classe propose un ensemble de methode qui peuvent eventuelement accepter un ou--}}
                            {{--                                    plusieurs parametres qui sont sont--}}
                            {{--                                    categoriser en 6 grand groupes.--}}
                            {{--                                </p>--}}
                            {{--                                <ul>--}}
                            {{--                                    <li>Les <strong>String</strong> @Exemple=> 'Fabrice' ,'toto','john'</li>--}}
                            {{--                                    <li>Les <strong>Integer</strong> @Exemple=> 1, 2, 3, 5</li>--}}
                            {{--                                    <li>Les <strong>Float</strong> @Exemple=> 1.5 , 2.5</li>--}}
                            {{--                                    <li>Les <strong>Boolean</strong> @Exemple=> true, false</li>--}}
                            {{--                                    <li>Les <strong>Array|List</strong></li>--}}
                            {{--                                    <li>Les <strong>DTO</strong> (data transfert object) qui est un object de--}}
                            {{--                                        regroupement des differents type precedants--}}
                            {{--                                    </li>--}}
                            {{--                                </ul>--}}


                            <h3>Listes des {{count($structreData->fonctions)}} fonctions contenus dans la classe : </h3>
                            @foreach($structreData->fonctions as $fonction)

                                <button type="button" class="functionButton btn btn-outline-warning btn-sm">
                                    #{{$fonction->nom}}()
                                </button>
                            @endforeach
                            <div class="functionBlockParents">
                                @foreach($structreData->fonctions as $fonction)
                                    <div class="functionBlock" style="">
                                        @foreach($fonction->params as $param)
                                            @if($param->type=="Dto")
                                                <h6 class="" style="color:#5e5873"><span
                                                        style="color:#ff9f43">@params</span> {{$param->name}}(
                                                    attrs: {{implode(' , ',$param->attributs)}} ) <span
                                                        style="color:#fd024c">{{$param->code}}</span></h6>
                                            @else
                                                <h6 class="" style="color:#5e5873"><span
                                                        style="color:#ff9f43">@params</span> {{$param->name}} <span
                                                        style="color:#fd024c">{{$param->code}} </h6>

                                            @endif
                                        @endforeach
                                        <h6 class="" style="color:#5e5873"><span
                                                style="color:#ff9f43">@return</span> {{$fonction->sortie}} </h6>
                                        <h5 class="" style="color:#e66819">
                                            #{{$fonction->nom}} ( <span
                                                style="color:#fd024c"> {{ implode(' , ',collect($fonction->params)->pluck('code')->toArray()) }} </span>)
                                        </h5>

                                        <p>{{$fonction->description}}</p>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>

@endsection
