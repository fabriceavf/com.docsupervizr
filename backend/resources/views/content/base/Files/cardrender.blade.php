@if(!empty($data))

    @php
        $imagesExtention=['jpeg','png','jpg','ico'];
        $img="images/icons/file-icons/doc.png";
        if(in_array( $data->extensions,$imagesExtention) ){
            $img=$data->web_path;

        }

    @endphp

    <div class="row" style=" width: 300px;
border: 1px solid #eee3e3;
border-radius: 5px;">
        <div class="card-body" style="display: flex;flex-direction: column;gap:10px;text-align: center">
            <div>
                <img src="{{asset($img)}}" alt="" style="width: 50px;height: 50px">
            </div>
            <div>
                {{$data->old_name ?? ""}}
            </div>
            <div style="display: flex;flex-direction: row;gap:10px;justify-content: center">

                <button class='btn btn-primary row-download'
                        onclick="window.open('{{route('web_download_files',[$data->id])}}', '_blank')"><i
                        class="fas fa-file-download"></i></button>
                <button class='btn btn-danger row-delete'><i class='fas fa-trash'></i></button>

            </div>


        </div>


    </div>

@endif

