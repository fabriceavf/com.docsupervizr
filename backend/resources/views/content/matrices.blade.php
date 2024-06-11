<table>
    <thead>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th>HS015</th>
        <th>HS026</th>
        <th>HS030</th>
        <th>HS055</th>
        <th>HS060</th>
        <th>HS115</th>
        <th>HS130</th>
        <th>NBJABS</th>
        <th>NBJPRES</th>
        <th>NBPA</th>
        <th>PPA</th>
        <th>PPN</th>
        <th>PPNA</th>
        <th>PPR</th>
        <th>PPRE</th>
        <th>PPRI</th>
        <th>PPEN</th>
        <th>PPSA</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>SOURCE</td>
        <td>MATRICULE</td>
        <td>NOMS PRENOMS</td>
        <td>HS a 15%</td>
        <td>HS a 26%</td>
        <td>HS a 30%</td>
        <td>HS a 55%</td>
        <td>HS a 60%</td>
        <td>HS a 115%</td>
        <td>HS a 130%</td>
        <td>NJA</td>
        <td>NJP</td>
        <td>NP</td>
        <td>PPA</td>
        <td>PPCUN</td>
        <td>PPNA</td>
        <td>PPR</td>
        <td>PPRE</td>
        <td>PPRI</td>
        <td>PPEN</td>
        <td>PPSA</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Totaux</td>
        <td>{{collect($datas)->sum('hs15')}}</td>
        <td>{{collect($datas)->sum('hs26')}}</td>
        <td>{{collect($datas)->sum('hs30')}}</td>
        <td>{{collect($datas)->sum('hs55')}}</td>
        <td>{{collect($datas)->sum('hs60')}}</td>
        <td>{{collect($datas)->sum('hs115')}}</td>
        <td>{{collect($datas)->sum('hs130')}}</td>
        <td>{{collect($datas)->sum('jour_abscence')}}</td>
        <td>{{collect($datas)->sum('jour_travail')}}</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
    </tr>
    @foreach($datas as $data)
        <tr>
            <td></td>
            <td>{{ $data['user']['matricule'] }}</td>
            <td>{{ $data['user']['nom'] }} {{ $data['user']['prenom'] }}</td>
            <td>{{ $data['hs15'] }} </td>
            <td>{{ $data['hs26'] }} </td>
            <td>{{ $data['hs30'] }} </td>
            <td>{{ $data['hs55'] }} </td>
            <td>{{ $data['hs60'] }} </td>
            <td>{{ $data['hs115'] }} </td>
            <td>{{ $data['hs130'] }} </td>
            <td>{{ $data['jour_abscence'] }}</td>
            <td>{{ $data['jour_travail'] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
