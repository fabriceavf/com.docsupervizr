@if(!empty($data))

    <div class="cardrendercomponent" style="

">
        <div style="display: flex; align-items: center;">

            {{ $data->id ?? "" }}

        </div>


        <div class="all_buttons">


            <button class='btn btn-primary row-switch'
                    data-attr-parents-val="{{is_array($data->id)? $data->id[0] : $data->id}}"><i class='fas fa-eye'></i>
            </button>

            <button class='btn btn-warning row-edit'><i class='fas fa-edit'></i></button>

            <button class='btn btn-danger row-delete'><i class='fas fa-trash'></i></button>


        </div>

    </div>

    <div class="form_element_child"></div>
    <div class="form_element_next" style="display:none">

    </div>

@endif

