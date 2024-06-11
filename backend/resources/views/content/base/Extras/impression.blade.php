<div class="card">
    <div class="card-body text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-home font-large-2 mb-1">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        <h5 class="card-title"></h5>
        <p class="card-text">

        </p>

        <!-- modal trigger button -->
        <div class="all_buttons">
            <a href="{{route('Extras_web_index_one',[
                       'Extras' => !empty($data->id)??1])}}">
                <button type="button" class="btn btn-primary waves-effect waves-float waves-light"
                        data-bs-toggle="modal">
                    Voir
                </button>
            </a>
            <button class="btn btn-secondary row-edit">Editer</button>
            <button class="btn btn-danger row-delete">Supprimer</button>

        </div>

    </div>
</div>
