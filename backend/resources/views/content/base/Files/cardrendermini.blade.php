@if(!empty($data))

    <div class="card">
        <div class="card-body text-center">

            <h5 class="card-title"></h5>
            <p class="card-text">

            </p>


            <div>

                old_name:
            </div>
            <div>

                {{$data->old_name ?? ""}}

            </div>


            <div>

                new_name:
            </div>
            <div>

                {{$data->new_name ?? ""}}

            </div>


            <div>

                descriptions:
            </div>
            <div>

                {{$data->descriptions ?? ""}}

            </div>


            <div>

                extensions:
            </div>
            <div>

                {{$data->extensions ?? ""}}

            </div>


            <div>

                size:
            </div>
            <div>

                {{$data->size ?? ""}}

            </div>


            <div>

                path:
            </div>
            <div>

                {{$data->path ?? ""}}

            </div>


            <div>

                web_path:
            </div>
            <div>

                {{$data->web_path ?? ""}}

            </div>


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
                    <button class="btn  btn-primary " onClick="window.location='{{URL::signedRoute('Files_web_index_one',[
                       'Files' => !empty($data->id)? $data->id:0])}}'"><i class='fas fa-eye'></i> Voir
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
