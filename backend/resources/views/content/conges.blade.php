<table>
    <thead>
    <tr>
        <th>SOURCE</th>
        <th> MATRICULE</th>
        <th> NOMS ET PRENOMS</th>
        <th>DEPART CONGE</th>
        <th>RETOUR CONGE</th>
        <th>DATE CESSATION</th>
        <th>MOTIF CESSATION</th>
        <th>OBSERVATIONS</th>

    </tr>
    </thead>
    <tbody>
    @foreach($datas as $data)
        <tr>
            <td></td>
            <td>{{ $data['user']['matricule'] }}</td>
            <td>{{ $data['user']['nom'] }} {{ $data['user']['prenom'] }}</td>
            <td>{{ $data['debut'] }} </td>
            <td>{{ $data['fin'] }} </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
