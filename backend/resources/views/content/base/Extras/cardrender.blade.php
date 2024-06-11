<div class="card">
    <div class="card-body text-center">
        @if($data->types=="TEXT"  )

            <p class="card-text">
                {{$data->libelle}}:
                {{$data->text}}

            </p>
        @endif
        @if($data->types=="TEXTAREA"  )

            <p class="card-text">
                {{$data->libelle}}:
                {{$data->textarea}}

            </p>
        @endif
        @if($data->types=="DATETIME"  )

            <p class="card-text">
                {{$data->libelle}}:
                {{$data->datetime}}

            </p>
        @endif
        @if($data->types=="FILES"  )

            <p class="card-text">
                {{$data->libelle}}:
                {!! $data->filesRender!!}

            </p>
        @endif

        <!-- modal trigger button -->
        <div class="all_buttons">

            <button class="btn btn-secondary row-edit">Editer</button>
            <button class="btn btn-danger row-delete">Supprimer</button>

        </div>

    </div>
</div>
