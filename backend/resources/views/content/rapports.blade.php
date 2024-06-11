<table>
    <thead>
    <tr>
        <th> Nom</th>
        <th> Prenom</th>
        <th> Matricule</th>

        @foreach($allDate as $date)
            <th> {{$date}}</th>
        @endforeach

        <th> Nbrs jour Present</th>
        <th> Nbrs jour Asbcent</th>
    </tr>
    </thead>
    <tbody>
    @foreach($datas as $userRapport)
        <tr>
            @foreach($userRapport as $pointage)
                <td>{{$pointage}}</td>
            @endforeach
        </tr>

    @endforeach

    </tbody>
</table>
