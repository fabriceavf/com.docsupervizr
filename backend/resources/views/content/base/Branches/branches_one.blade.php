@php
    use App\Models\prod\Tables_formulairesModel;use Illuminate\Support\Facades\DB;$function=[];
        $__internalId__=request()->get('__internalId__');
            $brancheslabels=DB::table('tables_labels')->where('tables','branches')->get();
          $brancheshide=DB::table('tables_labels')->where('tables','branches')->where('cacher','oui')
            ->get()
            ->map(function($data){
                return $data->nouveau;
            });
          $brancheshidedetails=DB::table('tables_labels')->where('tables','branches')->where('cacherdetails','oui')
            ->get()
            ->map(function($data){
                return $data->nouveau;
            })->toArray();
              $branchesrender=[];
              $branchesrenderdetails=[];
            foreach ($brancheslabels->toArray() as $cha){
                if(!empty($cha->render) && $cha->render!='false'){
                        $branchesrender[$cha->ancien]=$cha->render;


                }
                if(!empty($cha->renderdetails) && $cha->renderdetails!='false'){
                        $branchesrenderdetails[$cha->ancien]=$cha->renderdetails;


                }
            }
            $forms=Tables_formulairesModel::where('tables','branches')->get();
            if(!empty($forms->first()->disposition)){
                $forms=explode('_//_',$forms->first()->disposition);
            }else{
                $forms=[];
            }
            $newForms=[];
            foreach ($forms as $form){
                $newForms[]=explode('_/_',$form);
            }

            $function["getLabel_Branches_".$__internalId__]=function ($label,$labels){
                $reponse=$label;
              foreach ($labels as $lab){
                  if(strtolower($lab->ancien)==strtolower($label)){
                      $reponse=$lab->nouveau;
                      break;
                  }
              }
              return $reponse;

            }


@endphp


@extends('layouts/contentLayoutMaster')
@section('vendor-style')
    <!-- vendor css files -->

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
@endsection
@section('page-style')
    <link href="{{mix('css/personnal/editor/editor_beau_formulaire.css')}}" rel="stylesheet" type="text/css">
    <link href="{{mix('css/personnal/admin/admin.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/tables/datatables.searchHighLight.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/tables/select.datatables.css')) }}">



    <style>


    </style>
@endsection



@section('title',"branches")
@section('content')

    <script>

        let branchesrender_{{$__internalId__}} = {!! json_encode($branchesrender, JSON_HEX_TAG) !!};

        let hideColumnsbranches = {!! json_encode($brancheshide, JSON_HEX_TAG) !!};
    </script>


    <style>


    </style>


    <div class="container">
        {{ Breadcrumbs::render() }}
    </div>


    <div id='' class="container-fluid" style="display:none">

        <div class="row">
            <div class="card col-sm-12">
                <div class="card-header">
                    <h6 class="card-title"><i class="fa fa-user-md"></i> Manage Branches</h6>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                id="Branches_{{$__internalId__}}-tab"
                                data-toggle="tab"
                                href="#Branches_{{$__internalId__}}tab"
                                aria-controls="home"
                                role="tab"
                                aria-selected="true"
                            >
                                <i data-feather="home"></i> branches </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="Branches_{{$__internalId__}}tab" aria-labelledby="Branches-tab"
                             role="tabpanel">

                        </div>


                    </div>
                </div>
            </div>
        </div>


    </div>




    <div id='app' class="">
        <div id='form_branches_{{$__internalId__}}'></div>
        <div id='Branches_{{$__internalId__}}_app_vue' v-show='show_table'>

            <div class="col-md-12 ">
                <div class="col-sm-12 heading-bg">
                    <div class="card panel-heading" id="Branches_{{$__internalId__}}_tables_boutons">

                    </div>

                    <div class="card">
                        <div class="loader_page" id='loader_branches_{{$__internalId__}}'>
                            <div class="spinner-border text-light" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="card">
                                <div class="card-body text-center">

                                    <div class="test row">


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('family',$brancheshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{$function["getLabel_Branches_".$__internalId__]('family',$brancheslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Branches->family ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('adn',$brancheshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{$function["getLabel_Branches_".$__internalId__]('adn',$brancheslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Branches->adn ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('statut',$brancheshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{$function["getLabel_Branches_".$__internalId__]('statut',$brancheslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Branches->statut ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('created_at',$brancheshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{$function["getLabel_Branches_".$__internalId__]('created_at',$brancheslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Branches->created_at ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('createursRender',$brancheshidedetails))
                                                 style="display:none;"
                                            @endif

                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{$function["getLabel_Branches_".$__internalId__]('createurs',$brancheslabels)}}</h4>

                                                </div>
                                                <div class="card-body">

                                                    <p class="card-text">
                                                        {!! $Branches->CreateursRender ?? "" !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4">
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">
                                                    <h4 class="card-title">
                                                        Createurs:

                                                    </h4>
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        {{$Branches->CreateursCruds ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row index_one_buttons">


                                        <button class='btn btn-info text-dark '
                                                onclick="window.location.replace('{{$Branches->SignedImpressionUrl}}')">
                                            <i class='fas fa-print'></i> Imprimer
                                        </button>


                                        @can('update',$Branches)
                                            <button class="btn btn-secondary "
                                                    id="Branches_{{$__internalId__}}-row-edit">
                                                <i class='fas fa-edit'></i> Editer
                                            </button>
                                        @endcan
                                        @can('delete',$Branches)
                                            <button class="btn btn-danger "
                                                    id="Branches_{{$__internalId__}}-row-delete">
                                                <i class='fas fa-trash'></i> Supprimer
                                            </button>

                                        @endcan
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: none">
                            <input id="Branches_{{$__internalId__}}_rechercheDatatables" type="text"
                                   class="InputRechercheDatatable  form-control" placeholder="Entrez votre recherche">


                            <div id="Branches_{{$__internalId__}}_parents" class='tables'>

                                <table id='Branches_{{$__internalId__}}' class='display table table-striped'
                                       style='width:100%'>


                                    <thead
                                        @if($branches_disposition->disposition=="Component")
                                            style="display: none"

                                        @endif
                                    >
                                    <tr>
                                        <th></th>


                                        <th>{{$function["getLabel_Branches_".$__internalId__]('Family',$brancheslabels)}}</th>


                                        <th>{{$function["getLabel_Branches_".$__internalId__]('Adn',$brancheslabels)}}</th>


                                        <th>{{$function["getLabel_Branches_".$__internalId__]('CreateursRender',$brancheslabels)}}</th>


                                        <th>CardRender</th>
                                        <th>CardRenderComponent</th>
                                        <th>CardRenderSelect</th>
                                        <th> Action</th>

                                    </tr>
                                    </thead>

                                </table>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>


    </div>


    <div style="display:none">
        <div id='Branches_{{$__internalId__}}_customForm' style="">
            <div class="card-header">
                @if(!empty($branches_disposition->form_text) && $branches_disposition->form_text!='false' )
                    {!! $branches_disposition->form_text !!}
                @else
                    <h6 class="card-title"><i class="fa fa-user-md"></i> Manage Branches</h6>
                @endif
            </div>
            <div class="card-body">
                <div class="row">


                    @php
                        $branches_labForm=[];

                    foreach($brancheslabels as $lab){
                    if(!empty($lab->class) && $lab->class!='false'){
                                $branches_labForm[$lab->ancien]=$lab->class??'col-sm-12';

                    }else{
                    $branches_labForm[$lab->ancien]='col-sm-12';
                    }
                    }


                    @endphp


                    <div class='{{$branches_labForm['parents']??"col-sm-12"}}' data-editor-template='parents'></div>


                    <div class='{{$branches_labForm['family']??"col-sm-12"}}' data-editor-template='family'></div>


                    <div class='{{$branches_labForm['adn']??"col-sm-12"}}' data-editor-template='adn'></div>


                    <div class='{{$branches_labForm['statut']??"col-sm-12"}}' data-editor-template='statut'></div>


                </div>
            </div>
        </div>

    </div>

@endsection
@section('vendor-script')
    <script>
        import CustomSelect from "@/components/CustomSelect.vue";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
            }
        });


    </script>
    <!-- vendor files -->

    <script src="{{ asset(mix('vendors/js/tables/datatable/RowReorder/dataTables.rowReorder.min.js')) }}"></script>

@endsection
@section('page-script')

    @php
        $branches_editorLabels=[];

    foreach($brancheslabels as $lab){
    if(!empty($lab->editor_labels) && $lab->editor_labels!='false'){
    $branches_editorLabels[$lab->ancien]=$lab->editor_labels??'';
    }else{
    $branches_editorLabels[$lab->ancien]='';

    }

    }


    @endphp



    <script>
        import CustomSelect from "@/components/CustomSelect.vue";

        let Branches_Options_{{$__internalId__}}= {!! json_encode( $options??[] , JSON_HEX_TAG ) !!};


        function Branches_onPageDisplay_{{$__internalId__}}(elm) {
            var name = 'onPage' + Math.random();
            var Editor = $.fn.dataTable.Editor;
            var emptyInfo;

            Editor.display[name] = $.extend(true, {}, Editor.models.display, {
// Create the HTML mark-up needed the display controller
                init: function (editor) {
                    emptyInfo = elm.html();
                    return Editor.display[name];
                },

// Show the form
                open: function (editor, form, callback) {
                    elm.children().detach();
                    elm.append(form);

                    if (callback) {
                        callback();
                    }
                },

// Hide the form
                close: function (editor, callback) {
                    elm.children().detach();
                    elm.html(emptyInfo);

                    if (callback) {
                        callback();
                    }
                }
            });

            return name;
        }

        let Branches_editor_{{$__internalId__}}_config = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Branches_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Branches_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Branches_web_index')}}/_id_/delete"
                },
                cache: true

            },


            table: '#Branches_{{$__internalId__}}',


            template: '#Branches_{{$__internalId__}}_customForm',
            display: Branches_onPageDisplay_{{$__internalId__}}($('#form_branches_{{$__internalId__}}')),
            fields: [


                {
                    label: " {{!empty($branches_editorLabels['id'])?$branches_editorLabels['id']:'Id'}}  :",
                    name: "id",
                    submit: 'false'
                },


                {


                    label: " {{!empty($branches_editorLabels['parents'])?$branches_editorLabels['parents']:'Parents'}}  :",
                    name: "parents"
                    @if(request()->has('__key__parents'))
                    ,
                    def: "{{request()->get('__key__parents')}}"
                    @endif
                },


                {


                    label: " {{!empty($branches_editorLabels['family'])?$branches_editorLabels['family']:'Family'}}  :",
                    name: "family"
                    @if(request()->has('__key__family'))
                    ,
                    def: "{{request()->get('__key__family')}}"
                    @endif
                },


                {


                    label: " {{!empty($branches_editorLabels['adn'])?$branches_editorLabels['adn']:'Adn'}}  :",
                    name: "adn"
                    @if(request()->has('__key__adn'))
                    ,
                    def: "{{request()->get('__key__adn')}}"
                    @endif
                },


                {


                    label: " {{!empty($branches_editorLabels['statut'])?$branches_editorLabels['statut']:'Statut'}}  :",
                    name: "statut",
                    def: '0',
                    type: 'hidden'
                },


                {
                    label: " {{!empty($branches_editorLabels['extra_attributes'])?$branches_editorLabels['extra_attributes']:'Extra_attributes'}}  :",
                    name: "extra_attributes",
                    submit: 'false'
                },


                {
                    label: " {{!empty($branches_editorLabels['deleted_at'])?$branches_editorLabels['deleted_at']:'Deleted_at'}}  :",
                    name: "deleted_at",
                    submit: 'false'
                },


                {
                    label: " {{!empty($branches_editorLabels['created_at'])?$branches_editorLabels['created_at']:'Created_at'}}  :",
                    name: "created_at",
                    submit: 'false'
                },


                {
                    label: " {{!empty($branches_editorLabels['updated_at'])?$branches_editorLabels['updated_at']:'Updated_at'}}  :",
                    name: "updated_at",
                    submit: 'false'
                },


                {
                    label: " {{!empty($branches_editorLabels['createurs'])?$branches_editorLabels['createurs']:'Createurs'}}  :",
                    name: "createurs",
                    submit: 'false'
                },


                // les parents2


                // les enfants


            ],
        }
        let Branches_editor_{{$__internalId__}} = new $.fn.dataTable.Editor(Branches_editor_{{$__internalId__}}_config);


        Branches_editor_{{$__internalId__}}.dependent('id', function (val) {
            let ChildUrl = {}
            let retour = {}
            console.log('voici lid a changer de valeur', val)
            let childFiels = Branches_editor_{{$__internalId__}}_config.fields.filter(data => {
                let result = false;
                if (data.type) {
                    if (data.type == 'children') {
                        result = true
                    }
                }
                return result
            }).map(data => data.name)

            console.log('voici lid a changer de valeur et ca existe', childFiels, val)

            if (val) {
                retour['show'] = childFiels
                childFiels.forEach(data => {
                    let url = `${ChildUrl[data]}/branche_id/${val}`
                    Branches_editor_{{$__internalId__}}.field(data).update(url, 'branche_id', val)
                })

            } else {
                retour['hide'] = childFiels
            }
            return retour

        });
        Branches_editor_{{$__internalId__}}.on('preOpen', function () {
            $('#form_branches_{{$__internalId__}}').addClass('card')
            $('#Branches_{{$__internalId__}}_app_vue').hide()

        })
        Branches_editor_{{$__internalId__}}.on('close', function () {
            $('#form_branches_{{$__internalId__}}').removeClass('card')
            $('#Branches_{{$__internalId__}}_app_vue').show()


        })
        Branches_editor_{{$__internalId__}}.on('processing', function (e, processing) {
            if (processing) {
                $('body').addClass('processingBody')

            } else {
                $('body').removeClass('processingBody')

            }
        })

        Branches_editor_{{$__internalId__}}.on('preOpen', function () {

        })
        Branches_editor_{{$__internalId__}}.on('open', function () {
            console.log('on ouvre le formulaire1')
            console.log('on veut deplacer  le formulaire')
            $('.DTE_Form_Buttons .btn:eq(0)').addClass('btn-primary');
            $('.DTE_Form_Buttons .btn:eq(1)').addClass('btn-danger');
            $('#Branches_{{$__internalId__}}_parents').hide()
        })
        Branches_editor_{{$__internalId__}}.on('initSubmit', function (editor) {
            console.log('je mapprete a soumettre les donnees')


            @foreach($preselect as $key=>$value)
            Branches_editor_{{$__internalId__}}.field("{{$key}}").set("{{$value}}")
            @endforeach
        })
        Branches_editor_{{$__internalId__}}.on('submitSuccess', function () {
            console.log('je recharge les donnees')
            location.reload()
        })
        Branches_editor_{{$__internalId__}}.on('close', function () {
            $('#Branches_{{$__internalId__}}_parents').show()


        })


    </script>




    <script>
        import CustomSelect from "@/components/CustomSelect.vue";

        let donnes = [{!! json_encode($Branches, JSON_HEX_TAG) !!}];
        $(`#loader_branches_{{$__internalId__}}`).css('display', 'none')


        let Branches_table_{{$__internalId__}} = $('#Branches_{{$__internalId__}}').DataTable({

            data: donnes,


            searchHighlight: true,
            language: {
                search: 'Chercher:',
                zeroRecords: 'aucun resultats',
                sSearchPlaceholder: 'Entrez votre recherche',
            },
            fixedHeader: true,
            // columnDefs: [{
            //     orderable: false,
            //     className: 'select-checkbox',
            //     targets: 0
            // }],
            // select: {
            //     style: 'os',
            //     selector: 'td:first-child'
            // },
            paging: true,
            lengthMenu: [[10, 50, 100], [10, 50, 100]],
            colReorder: {
                realtime: false,
            },
            dom: 'lBtip',
            responsive: true,
            deferRender: true,
            buttons: [], columns: [

                {
                    data: null, render: function (data, type, row) {
                        let rendered = ""
                        if (branchesrender_{{$__internalId__}}.indexOf('id') != -1) {
                            let template = Handlebars.compile(branchesrender['id']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },
                // {data: 'PipelinesAvf'},


                // la donnee id  {data: 'id'},
// la donnee label

                {
                    data: 'family', render: function (data, type, row) {
                        let rendered = data

                        if (branchesrender_{{$__internalId__}}.indexOf('family') != -1) {
                            let template = Handlebars.compile(branchesrender['family']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },


                {
                    data: 'adn', render: function (data, type, row) {
                        let rendered = data

                        if (branchesrender_{{$__internalId__}}.indexOf('adn') != -1) {
                            let template = Handlebars.compile(branchesrender['adn']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },


                {
                    data: 'CreateursRender', render: function (data, type, row) {
                        let rendered = data
                        if (branchesrender_{{$__internalId__}}.indexOf('CreateursRender') != -1) {

                            let template = Handlebars.compile(branchesrender['CreateursRender']);
                            rendered = template({data: data, all: row});
                            //

                        }
                        return rendered;
                    }
                },

                // la donnee user_id  {data: 'user_id'},
                // // la donnee fichiers fichiers
                //                         {
                //                             data: null, render: function (data, type, row) {
                //                                 return `${data.fichiers.length} Fichiers `;
                //                             }
                //                         },
                // // la donnee extras extras
                //                         {
                //                             data: null, render: function (data, type, row) {
                //                                 return `${data.extras.length} Extras `;
                //                             }
                //                         },
                // // la donnee forusers forusers
                //                         {
                //                             data: null, render: function (data, type, row) {
                //                                 return `${data.forusers.length} Users `;
                //                             }
                //                         },
                // // la donnee forgroupes forgroupes
                //                         {
                //                             data: null, render: function (data, type, row) {
                //                                 return `${data.forgroupes.length} Groupes `;
                //                             }
                //                         },
                // // la donnee extra_attributes  {data: 'extra_attributes'},
                // la donnee deleted_at
                // {data: 'deleted_at'},
                // la donnee created_at
                // {data: 'created_at'},
                // la donnee updated_at
                // {data: 'CreateursCruds'},


                // {data: 'CardRender'},
                {
                    data: null, render: function (data, type, row) {
                        return `

                    @if(!request()->has('imprimer') || intval(request()->get('impression'))!=0)
                        <a href='${data.SignedImpressionUrl}'>
                        <button class='btn text-dark p-0 text-center'><i class='fas fa-print'></i></button>
                    </a>
                    @endif
                        @if(!request()->has('voir') || intval(request()->get('voir'))!=0)
                        <a href='${data.SignedShowUrl}'>
                       <i class='fas fa-eye'></i>
                    </a>
                    @endif
                        @if(!request()->has('crud') || intval(request()->get('crud'))!=0)

                        <button style="${!data.CanEditPerms ? 'display:none' : null}" class='btn text-info  row-edit p-0 text-center' data-url="${data.SignedEditUrl}"><i class='fas fa-edit'></i></button>

                                <button  style="${!data.CanDeletePerms ? 'display:none' : null}" class='btn text-danger p-0  row-delete text-center' data-url="${data.SignedDeleteUrl}"><i class='fas fa-trash'></i></button>
                    @endif
                        `;
                    }
                },

            ],
        });


        $('#Branches_{{$__internalId__}}-row-edit').on('click', function (e) {

            let tr = {!! json_encode($Branches, JSON_HEX_TAG) !!};


            Branches_editor_{{$__internalId__}}.field('createurs').hide()


            Branches_editor_{{$__internalId__}}.edit(tr, {
                title: 'Delete record',
                buttons: [
                    'Editer',
                    {
                        text: 'Annuler', action: function () {
                            this.close();
                        }
                    }
                ]
            });
        });

        // Delete row
        $('#Branches_{{$__internalId__}}-row-delete').on('click', function (e) {


            let tr = {!! json_encode($Branches, JSON_HEX_TAG) !!};


            Branches_editor_{{$__internalId__}}.remove(tr, {
                title: 'Supprimer cette donnees',
                message: 'Etes vous sur de vouloir supprimer cette donnee ?',
                buttons: [{
                    text: 'Non', action: function () {
                        this.close();
                    }
                },
                    'Oui'
                ]
            });
        });


    </script>

@endsection
