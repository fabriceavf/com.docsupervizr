<div
    style="margin-top:10px ;box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px;width: 98%;margin: 0 auto;padding: 10px;border: 1px solid #04040438;border-radius: 5px;">
    <h2 style="text-align:center;text-transform: uppercase;">
        Programmation du {{ Carbon\Carbon::parse($datas->date_debut)->format(' d-m-Y') }}
        au {{ Carbon\Carbon::parse($datas->date_fin)->format(' d-m-Y') }}
    </h2>


    <table
        style="border-spacing: 2px;width:100%;margin:30px auto ;        border-spacing: 2px; width: 100%; margin: 30px auto;">

        <tr>
            <th
                style="width: 10%; text-align: center; padding: 5px; border: 1px solid black; background-color: lightgray;">
                <b>Matricule</b>
            </th>
            <th
                style="width: 10%;text-align: center; padding: 5px;border: 1px solid black; background-color: lightgray;">
                <b>Nom</b>
            </th>
            <th
                style="width: 10%;text-align: center; padding: 5px; border: 1px solid black; background-color: lightgray;">
                <b>Prenom</b>
            </th>
            @foreach ($datas->AllDatesInRange as $programm)
                <th
                    style="width: 10%; text-align: center;padding: 5px;border: 1px solid black; background-color: lightgray;">
                    <b>{{ $programm }}</b>
                </th>
            @endforeach

        </tr>
        @foreach ($users as $key => $user)
            <tr>
                <td style="width: 10%; text-align: center; padding: 5px; border: 1px solid black;" width="10%">
                    {{ $user->matricule }}</td>
                <td style="width: 10%;text-align: center;padding: 5px; border: 1px solid black;" width="10%">
                    {{ $user->nom }}</td>
                <td style=" width: 10%;text-align: center; padding: 5px;border: 1px solid black;" width="10%">
                    {{ $user->prenom }}</td>
                @php
                    $programmes = $user
                        ->programmes()
                        ->where('programmation_id', $datas->id)
                        ->get();
                @endphp
                @foreach ($programmes as $programm)
                    <td style="width: 10%;text-align: center; padding: 5px;border: 1px solid black;">
                        @if ($programm->horaire)
                            {{ $programm->horaire->libelle }}
                        @endif
                    </td>
                @endforeach

            </tr>
        @endforeach

    </table>
</div>
{{-- <style>
    /* .dataBlock {
        box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px;
        width: 98%;
        margin: 0 auto;
        padding: 10px;
        border: 1px solid #04040438;
        border-radius: 5px;
    }

    /* Appliquer une largeur fixe aux cellules du tableau */
    table {
        border-spacing: 2px;
        width: 100%;
        margin: 30px auto;
    } */

    th,
    td {
        width: 10%;

        text-align: center;

        padding: 5px;

        border: 1px solid black;
        /* Ajouter des bordures pour chaque cellule */
    }

    th {
        background-color: lightgray;
        /* Ajouter une couleur de fond aux en-têtes */
    }
</style> --}}
