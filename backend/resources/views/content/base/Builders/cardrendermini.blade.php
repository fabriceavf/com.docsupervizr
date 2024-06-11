@if(!empty($data))

    <div class="card">
        <div class="card-body text-center">

            <h5 class="card-title"></h5>
            <p class="card-text">

            </p>


            <div>

                statut:
            </div>
            <div>

                {{$data->statut ?? ""}}

            </div>


            <div>

                created_at:
            </div>
            <div>

                {{$data->created_at ?? ""}}

            </div>


            <div>

                createurs:
            </div>
            <div>
                {!! $data->CreateursRender ?? "" !!}

            </div>


            <div>
                Createurs:
            </div>
            <div>
                {{$data->CreateursCruds ?? ""}}
            </div>


            <!-- modal trigger button -->
            <div>
                <div class="all_buttons">
                    <button class="btn  btn-primary " onClick="window.location='{{URL::signedRoute('Builders_web_index_one',[
                       'Builders' => !empty($data->id)? $data->id:0])}}'"><i class='fas fa-eye'></i> Voir
                    </button>
                    @can('update',$data)
                        <button class='btn btn-warning row-edit'><i class='fas fa-edit'></i> Editer</button>
                    @endcan
                    @can('delete',$data)
                        <button class='btn btn-danger row-delete'><i class='fas fa-trash'></i> Supprimer</button>
                    @endcan


                </div>

            </div>


        </div>
    </div>

@endif
