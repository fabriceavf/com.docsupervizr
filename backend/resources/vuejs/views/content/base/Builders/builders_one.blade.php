@php
    use App\Models\prod\Tables_formulairesModel;use Illuminate\Support\Facades\DB;$builderslabels=DB::table('tables_labels')->where('tables','builders')->get();
  $buildershide=DB::table('tables_labels')->where('tables','builders')->where('cacher','oui')
    ->get()
    ->map(function($data){
        return $data->nouveau;
    });
  $buildershidedetails=DB::table('tables_labels')->where('tables','builders')->where('cacherdetails','oui')
    ->get()
    ->map(function($data){
        return $data->nouveau;
    })->toArray();
      $buildersrender=[];
      $buildersrenderdetails=[];
    foreach ($builderslabels->toArray() as $cha){
        if(!empty($cha->render) && $cha->render!='false'){
                $buildersrender[$cha->ancien]=$cha->render;


        }
        if(!empty($cha->renderdetails) && $cha->renderdetails!='false'){
                $buildersrenderdetails[$cha->ancien]=$cha->renderdetails;


        }
    }
    $forms=Tables_formulairesModel::where('tables','builders')->get();
    if(!empty($forms->first()->disposition)){
        $forms=explode('_//_',$forms->first()->disposition);
    }else{
        $forms=[];
    }
    $newForms=[];
    foreach ($forms as $form){
        $newForms[]=explode('_/_',$form);
    }
    function getLabelBuilders($label,$labels){
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

    <script>
        let buildersrender = {!! json_encode($buildersrender, JSON_HEX_TAG) !!};

        let hideColumnsbuilders = {!! json_encode($buildershide, JSON_HEX_TAG) !!};
    </script>


    <style>


    </style>
@endsection



@section('title',"builders")
@section('content')

    <div class="container">
        {{ Breadcrumbs::render() }}
    </div>


    <div id='' class="container-fluid" style="display:none">

        <div class="row">
            <div class="card col-sm-12">
                <div class="card-header">
                    <h6 class="card-title"><i class="fa fa-user-md"></i> Manage Builders</h6>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a
                                    class="nav-link active"
                                    id="Builders-tab"
                                    data-toggle="tab"
                                    href="#Builderstab"
                                    aria-controls="home"
                                    role="tab"
                                    aria-selected="true"
                            >
                                <i data-feather="home"></i> builders </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="Builderstab" aria-labelledby="Builders-tab" role="tabpanel">

                        </div>


                    </div>
                </div>
            </div>
        </div>


    </div>




    <div id='app' class="">
        <div id='form_builders'></div>
        <div id='builders_app_vue' v-show='show_table'>

            <div class="col-md-12 ">
                <div class="col-sm-12 heading-bg">
                    <div class="card panel-heading" id="Builders_tables_boutons">

                    </div>

                    <div class="card">
                        <div class="loader_page" id='loader_builders'>
                            <div class="spinner-border text-light" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="card">
                                <div class="card-body text-center">

                                    <div class="test row">


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('statut',$buildershidedetails))
                                                 style="display:none;"
                                                @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelBuilders('statut',$builderslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Builders->statut ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('created_at',$buildershidedetails))
                                                 style="display:none;"
                                                @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelBuilders('created_at',$builderslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Builders->created_at ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('createursRender',$buildershidedetails))
                                                 style="display:none;"
                                                @endif

                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelBuilders('createurs',$builderslabels)}}</h4>

                                                </div>
                                                <div class="card-body">

                                                    <p class="card-text">
                                                        {!! $Builders->CreateursRender ?? "" !!}
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
                                                        {{$Builders->CreateursCruds ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row index_one_buttons">


                                        <button class='btn btn-info text-dark '
                                                onclick="window.location.replace('{{$Builders->SignedImpressionUrl}}')">
                                            <i class='fas fa-print'></i> Imprimer
                                        </button>


                                        @can('update',$Builders)
                                            <button class="btn btn-secondary " id="builders-row-edit">
                                                <i class='fas fa-edit'></i> Editer
                                            </button>
                                        @endcan
                                        @can('delete',$Builders)
                                            <button class="btn btn-danger " id="builders-row-delete">
                                                <i class='fas fa-trash'></i> Supprimer
                                            </button>

                                        @endcan
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: none">
                            <input id="Builders_rechercheDatatables" type="text"
                                   class="InputRechercheDatatable  form-control" placeholder="Entrez votre recherche">


                            <div id="Builders_parents" class='tables'>

                                <table id='Builders' class='display table table-striped' style='width:100%'>
                                    <thead>
                                    <tr>
                                        <th></th>


                                        <th>{{getLabelBuilders('CreateursRender',$builderslabels)}}</th>


                                        <th>CardRender</th>
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


    <div id='Builders_customForm'>
        <div class="card-header">
            @if(!empty($builders_disposition->form_text) && $builders_disposition->form_text!='false' )
                {!! $builders_disposition->form_text !!}
            @else
                <h6 class="card-title"><i class="fa fa-user-md"></i> Manage Builders</h6>
            @endif
        </div>
        <div class="card-body">
            <div class="row">


                @php
                    $builders_labForm=[];

                foreach($builderslabels as $lab){
                if(!empty($lab->class) && $lab->class!='false'){
                            $builders_labForm[$lab->ancien]=$lab->class??'col-sm-12';

                }else{
                $builders_labForm[$lab->ancien]='col-sm-12';
                }
                }


                @endphp


                <div class='{{$builders_labForm['statut']??"col-sm-12"}}' data-editor-template='statut'></div>


            </div>
        </div>
    </div>

@endsection
@section('vendor-script')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
            }
        });


    </script>
    <!-- vendor files -->

@endsection
@section('page-script')

    @php
        $builders_editorLabels=[];

    foreach($builderslabels as $lab){
    if(!empty($lab->editor_labels) && $lab->editor_labels!='false'){
    $builders_editorLabels[$lab->ancien]=$lab->editor_labels??'';
    }else{
    $builders_editorLabels[$lab->ancien]='';

    }

    }


    @endphp



    <script>

        let Builders_Options = {!! json_encode( $options??[] , JSON_HEX_TAG ) !!};


        function Builders_onPageDisplay(elm) {
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

        let Builders_editor_config = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Builders_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Builders_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Builders_web_index')}}/_id_/delete"
                },
                cache: true

            },


            table: '#Builders',


            template: '#Builders_customForm',
            display: Builders_onPageDisplay($('#form_builders')),
            fields: [


                {
                    label: " {{!empty($builders_editorLabels['id'])?$builders_editorLabels['id']:'Id'}}  :",
                    name: "id",
                    submit: 'false'
                },


                {


                    label: " {{!empty($builders_editorLabels['statut'])?$builders_editorLabels['statut']:'Statut'}}  :",
                    name: "statut",
                    def: '0',
                    type: 'hidden'
                },


                {
                    label: " {{!empty($builders_editorLabels['extra_attributes'])?$builders_editorLabels['extra_attributes']:'Extra_attributes'}}  :",
                    name: "extra_attributes",
                    submit: 'false'
                },


                {
                    label: " {{!empty($builders_editorLabels['deleted_at'])?$builders_editorLabels['deleted_at']:'Deleted_at'}}  :",
                    name: "deleted_at",
                    submit: 'false'
                },


                {
                    label: " {{!empty($builders_editorLabels['created_at'])?$builders_editorLabels['created_at']:'Created_at'}}  :",
                    name: "created_at",
                    submit: 'false'
                },


                {
                    label: " {{!empty($builders_editorLabels['updated_at'])?$builders_editorLabels['updated_at']:'Updated_at'}}  :",
                    name: "updated_at",
                    submit: 'false'
                },


                {
                    label: " {{!empty($builders_editorLabels['createurs'])?$builders_editorLabels['createurs']:'Createurs'}}  :",
                    name: "createurs",
                    submit: 'false'
                },


                // les parents2


                // les enfants


            ],
        }
        let Builders_editor = new $.fn.dataTable.Editor(Builders_editor_config);


        Builders_editor.dependent('id', function (val) {
            let ChildUrl = {}
            let retour = {}
            console.log('voici lid a changer de valeur', val)
            let childFiels = Builders_editor_config.fields.filter(data => {
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
                    let url = `${ChildUrl[data]}/builder_id/${val}`
                    Builders_editor.field(data).update(url, 'builder_id', val)
                })

            } else {
                retour['hide'] = childFiels
            }
            return retour

        });
        Builders_editor.on('preOpen', function () {
            $('#form_builders').addClass('card')
            $('#builders_app_vue').hide()

        })
        Builders_editor.on('close', function () {
            $('#form_builders').removeClass('card')
            $('#builders_app_vue').show()


        })
        Builders_editor.on('processing', function (e, processing) {
            if (processing) {
                $('body').addClass('processingBody')

            } else {
                $('body').removeClass('processingBody')

            }
        })

        Builders_editor.on('preOpen', function () {

        })
        Builders_editor.on('open', function () {
            console.log('on ouvre le formulaire')
            console.log('on veut deplacer  le formulaire')
            $('.DTE_Form_Buttons .btn:eq(0)').addClass('btn-primary');
            $('.DTE_Form_Buttons .btn:eq(1)').addClass('btn-danger');
            $('#Builders_parents').hide()
        })
        Builders_editor.on('initSubmit', function (editor) {
            console.log('je mapprete a soumettre les donnees')


            @foreach($preselect as $key=>$value)
            Builders_editor.field("{{$key}}").set("{{$value}}")
            @endforeach
        })
        Builders_editor.on('submitSuccess', function () {
            console.log('je recharge les donnees')
            location.reload()
        })
        Builders_editor.on('close', function () {
            $('#Builders_parents').show()


        })


    </script>




    <script>
        let donnes = [{!! json_encode($Builders, JSON_HEX_TAG) !!}];
        $(`#loader_builders`).css('display', 'none')


        let Builders_table = $('#Builders').DataTable({

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
                        if (buildersrender.indexOf('id') != -1) {
                            let template = Handlebars.compile(buildersrender['id']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },
                // {data: 'PipelinesAvf'},


                // la donnee id  {data: 'id'},
// la donnee label

                {
                    data: 'CreateursRender', render: function (data, type, row) {
                        let rendered = data
                        if (buildersrender.indexOf('CreateursRender') != -1) {

                            let template = Handlebars.compile(buildersrender['CreateursRender']);
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

                        <button style="${!data.CanEditPerms ? 'display:none' : null}" class='btn text-info row-edit p-0 text-center' data-url="${data.SignedEditUrl}"><i class='fas fa-edit'></i></button>

                                <button  style="${!data.CanDeletePerms ? 'display:none' : null}" class='btn btn-danger  row-delete text-center' data-url="${data.SignedDeleteUrl}"><i class='fas fa-trash'></i></button>
                    @endif
                        `;
                    }
                },

            ],
        });


        $('#builders-row-edit').on('click', function (e) {

            let tr = {!! json_encode($Builders, JSON_HEX_TAG) !!};


            Builders_editor.field('createurs').hide()


            Builders_editor.edit(tr, {
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
        $('#builders-row-delete').on('click', function (e) {


            let tr = {!! json_encode($Builders, JSON_HEX_TAG) !!};


            Builders_editor.remove(tr, {
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
