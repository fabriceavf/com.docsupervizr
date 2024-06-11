<style>
    .dataBlock {
        box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px;
        width: 98%;
        margin: 0 auto;
        padding: 10px;
        border: 1px solid #04040438;
        border-radius: 5px;
    }

    tr {
        border-bottom: 2px dashed #b3b3b3;
    }

    .check {
        width: 20px;
        display: inline-block;
        border: 2px #8a8484 solid;
        height: 20px;
        border-radius: 5px;
    }

    .check1 {
        width: 90%;
        display: inline-block;
        border: 2px #8a8484 solid;
        height: 50px;
        border-radius: 5px;
        margin-top: 5px;
    }
</style>
<div class="row">
    @php
        $date=Carbon\Carbon::parse($data->date_debut);
        $logo=request()->get('assetDomain').'://'.request()->get('assetUrl').'/'.strtolower(Helper::getAppName()).'.supervizr.png'
    @endphp
    <div class="col-sm-12" style="margin:10px auto">
        <h2 style="text-align:center;margin:10px"> {{$data->libelle}} du {{$date->format('d/m/Y')}}</h2>
        <div style="margin:10px auto;">

            @foreach($clients as $client)
                <div
                    style=" box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px; width: 98%;margin: 0 auto;padding: 10px; border: 1px solid #04040438;border-radius: 5px;">
                    Client: {{ $client->libelle }}
                </div>
                <div
                    style="margin-top:10px; box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px;width: 98%;margin: 0 auto;padding: 10px;border: 1px solid #04040438; border-radius: 5px;">
                    @foreach ($sites as $site)
                        @if($site->client_id==$client->id)
                            <h2 style="text-align:center">
                                Site : {{$site->libelle}}
                            </h2>


                            @foreach($postes as $poste)
                                @if($poste->site_id==$site->id)

                                    <table
                                        style="width:100%;margin:30px auto; border-collapse: collapse;  border: 1px dotted black;">

                                        <tr style=" border-bottom: 2px dashed #b3b3b3;">
                                            <th width="10%"><b>Matricule</b></th>
                                            <th width="10%"><b>Nom</b></th>
                                            <th width="10%"><b>Prenom</b></th>
                                            <th width="25%"><b>Poste</b></th>
                                            <th width="25%"><b>Remplacant</b></th>
                                            <th width="10%"><b>Present</b></th>
                                            <th width="10%"><b>abscent</b></th>
                                        </tr>
                                        @foreach($data['Allusers'] as $key=>$donne)
                                            @if($donne->posteId==$poste->id)
                                                <tr>
                                                    <td width="10%">{{ $donne->matricule }}</td>
                                                    <td width="10%">{{ $donne->nom }}</td>
                                                    <td width="10%">{{ $donne->prenom }}</td>
                                                    <td width="25%">{{ $poste->libelle }}</td>
                                                    <td width="25%"><span
                                                            style="width: 90%; display: inline-block;border: 2px #8a8484 solid; height: 50px;border-radius: 5px;margin-top: 5px;"></span>
                                                    </td>
                                                    <td width="10%">
                                                        <span
                                                            style=" width: 20px;display: inline-block; border: 2px #8a8484 solid;height: 20px; border-radius: 5px;"></span>

                                                    </td>
                                                    <td width="10%">

                                                        <span
                                                            style=" width: 20px;display: inline-block; border: 2px #8a8484 solid;height: 20px; border-radius: 5px;"></span>

                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @foreach(range(0,5) as $donne)
                                            <tr>
                                                <td width="10%"><span
                                                        style="width: 90%; display: inline-block; border: 2px #8a8484 solid; height: 50px; border-radius: 5px; margin-top: 5px;"></span>
                                                </td>
                                                <td width="10%"><span
                                                        style="width: 90%; display: inline-block; border: 2px #8a8484 solid; height: 50px; border-radius: 5px; margin-top: 5px;"></span>
                                                </td>
                                                <td width="10%"><span
                                                        style="width: 90%; display: inline-block; border: 2px #8a8484 solid; height: 50px; border-radius: 5px; margin-top: 5px;"></span>
                                                </td>
                                                <td width="15%">{{ $poste->libelle }}</td>
                                                <td width="25%"><span
                                                        style="width: 90%; display: inline-block; border: 2px #8a8484 solid; height: 50px; border-radius: 5px; margin-top: 5px;"></span>
                                                </td>
                                                <td width="25%"><span
                                                        style=" width: 20px;display: inline-block; border: 2px #8a8484 solid;height: 20px; border-radius: 5px;"></span>
                                                </td>
                                                <td width="10%"><span
                                                        style=" width: 20px;display: inline-block; border: 2px #8a8484 solid;height: 20px; border-radius: 5px;"></span>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </table>

                                @endif
                            @endforeach()

                        @endif
                    @endforeach()
                </div>
            @endforeach()
        </div>


    </div>

</div>
