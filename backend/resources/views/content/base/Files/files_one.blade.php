@php
    use App\Models\prod\Tables_formulairesModel;use Illuminate\Support\Facades\DB;$fileslabels=DB::table('tables_labels')->where('tables','files')->get();
  $fileshide=DB::table('tables_labels')->where('tables','files')->where('cacher','oui')
    ->get()
    ->map(function($data){
        return $data->nouveau;
    });
  $fileshidedetails=DB::table('tables_labels')->where('tables','files')->where('cacherdetails','oui')
    ->get()
    ->map(function($data){
        return $data->nouveau;
    })->toArray();
      $filesrender=[];
      $filesrenderdetails=[];
    foreach ($fileslabels->toArray() as $cha){
        if(!empty($cha->render) && $cha->render!='false'){
                $filesrender[$cha->ancien]=$cha->render;


        }
        if(!empty($cha->renderdetails) && $cha->renderdetails!='false'){
                $filesrenderdetails[$cha->ancien]=$cha->renderdetails;


        }
    }
    $forms=Tables_formulairesModel::where('tables','files')->get();
    if(!empty($forms->first()->disposition)){
        $forms=explode('_//_',$forms->first()->disposition);
    }else{
        $forms=[];
    }
    $newForms=[];
    foreach ($forms as $form){
        $newForms[]=explode('_/_',$form);
    }
    function getLabelFiles($label,$labels){
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

        let filesrender = {!! json_encode($filesrender, JSON_HEX_TAG) !!};

        let hideColumnsfiles = {!! json_encode($fileshide, JSON_HEX_TAG) !!};
    </script>


    <style>


    </style>
@endsection



@section('title',"files")
@section('content')

    <div class="container">
        {{ Breadcrumbs::render() }}
    </div>


    <div id='' class="container-fluid" style="display:none">

        <div class="row">
            <div class="card col-sm-12">
                <div class="card-header">
                    <h6 class="card-title"><i class="fa fa-user-md"></i> Manage Files</h6>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                id="Files-tab"
                                data-toggle="tab"
                                href="#Filestab"
                                aria-controls="home"
                                role="tab"
                                aria-selected="true"
                            >
                                <i data-feather="home"></i> files </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="Filestab" aria-labelledby="Files-tab" role="tabpanel">

                        </div>


                    </div>
                </div>
            </div>
        </div>


    </div>




    <div id='app' class="">
        <div id='form_files'></div>
        <div id='files_app_vue' v-show='show_table'>

            <div class="col-md-12 ">
                <div class="col-sm-12 heading-bg">
                    <div class="card panel-heading" id="Files_tables_boutons">

                    </div>

                    <div class="card">
                        <div class="loader_page" id='loader_files'>
                            <div class="spinner-border text-light" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="card">
                                <div class="card-body text-center">

                                    <div class="test row">


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('old_name',$fileshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelFiles('old_name',$fileslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Files->old_name ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('new_name',$fileshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelFiles('new_name',$fileslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Files->new_name ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('descriptions',$fileshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelFiles('descriptions',$fileslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Files->descriptions ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('extensions',$fileshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelFiles('extensions',$fileslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Files->extensions ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('size',$fileshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelFiles('size',$fileslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Files->size ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('path',$fileshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelFiles('path',$fileslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Files->path ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('web_path',$fileshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelFiles('web_path',$fileslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Files->web_path ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('statut',$fileshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelFiles('statut',$fileslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Files->statut ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('created_at',$fileshidedetails))
                                                 style="display:none;"
                                            @endif
                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelFiles('created_at',$fileslabels)}}</h4>

                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text"> {{$Files->created_at ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4"
                                             @if( in_array('createursRender',$fileshidedetails))
                                                 style="display:none;"
                                            @endif

                                        >
                                            <div class="card shadow-none bg-transparent border-primary">
                                                <div class="card-header">

                                                    <h4 class="card-title">{{getLabelFiles('createurs',$fileslabels)}}</h4>

                                                </div>
                                                <div class="card-body">

                                                    <p class="card-text">
                                                        {!! $Files->CreateursRender ?? "" !!}
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
                                                        {{$Files->CreateursCruds ?? ""}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row index_one_buttons">


                                        <button class='btn btn-info text-dark '
                                                onclick="window.location.replace('{{$Files->SignedImpressionUrl}}')"><i
                                                class='fas fa-print'></i> Imprimer
                                        </button>


                                        @can('update',$Files)
                                            <button class="btn btn-secondary " id="files-row-edit">
                                                <i class='fas fa-edit'></i> Editer
                                            </button>
                                        @endcan
                                        @can('delete',$Files)
                                            <button class="btn btn-danger " id="files-row-delete">
                                                <i class='fas fa-trash'></i> Supprimer
                                            </button>

                                        @endcan
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: none">
                            <input id="Files_rechercheDatatables" type="text"
                                   class="InputRechercheDatatable  form-control" placeholder="Entrez votre recherche">


                            <div id="Files_parents" class='tables'>

                                <table id='Files' class='display table table-striped' style='width:100%'>
                                    <thead>
                                    <tr>
                                        <th></th>


                                        <th>{{getLabelFiles('Old_name',$fileslabels)}}</th>


                                        <th>{{getLabelFiles('New_name',$fileslabels)}}</th>


                                        <th>{{getLabelFiles('Descriptions',$fileslabels)}}</th>


                                        <th>{{getLabelFiles('Extensions',$fileslabels)}}</th>


                                        <th>{{getLabelFiles('Size',$fileslabels)}}</th>


                                        <th>{{getLabelFiles('Path',$fileslabels)}}</th>


                                        <th>{{getLabelFiles('Web_path',$fileslabels)}}</th>


                                        <th>{{getLabelFiles('CreateursRender',$fileslabels)}}</th>


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


    <div id='Files_customForm'>
        <div class="card-header">
            @if(!empty($files_disposition->form_text) && $files_disposition->form_text!='false' )
                {!! $files_disposition->form_text !!}
            @else
                <h6 class="card-title"><i class="fa fa-user-md"></i> Manage Files</h6>
            @endif
        </div>
        <div class="card-body">
            <div class="row">


                @php
                    $files_labForm=[];

                foreach($fileslabels as $lab){
                if(!empty($lab->class) && $lab->class!='false'){
                            $files_labForm[$lab->ancien]=$lab->class??'col-sm-12';

                }else{
                $files_labForm[$lab->ancien]='col-sm-12';
                }
                }


                @endphp


                <div class='{{$files_labForm['id']??"col-sm-12"}}' data-editor-template='id'></div>


                <div class='{{$files_labForm['old_name']??"col-sm-12"}}' data-editor-template='old_name'></div>


                <div class='{{$files_labForm['new_name']??"col-sm-12"}}' data-editor-template='new_name'></div>


                <div class='{{$files_labForm['descriptions']??"col-sm-12"}}' data-editor-template='descriptions'></div>


                <div class='{{$files_labForm['extensions']??"col-sm-12"}}' data-editor-template='extensions'></div>


                <div class='{{$files_labForm['size']??"col-sm-12"}}' data-editor-template='size'></div>


                <div class='{{$files_labForm['path']??"col-sm-12"}}' data-editor-template='path'></div>


                <div class='{{$files_labForm['web_path']??"col-sm-12"}}' data-editor-template='web_path'></div>


                <div class='{{$files_labForm['statut']??"col-sm-12"}}' data-editor-template='statut'></div>


                <div class='{{$files_labForm['extra_attributes']??"col-sm-12"}}'
                     data-editor-template='extra_attributes'></div>


                <div class='{{$files_labForm['deleted_at']??"col-sm-12"}}' data-editor-template='deleted_at'></div>


                <div class='{{$files_labForm['created_at']??"col-sm-12"}}' data-editor-template='created_at'></div>


                <div class='{{$files_labForm['updated_at']??"col-sm-12"}}' data-editor-template='updated_at'></div>


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

@endsection
@section('page-script')

    @php
        $files_editorLabels=[];

    foreach($fileslabels as $lab){
    if(!empty($lab->editor_labels) && $lab->editor_labels!='false'){
    $files_editorLabels[$lab->ancien]=$lab->editor_labels??'';
    }else{
    $files_editorLabels[$lab->ancien]='';

    }

    }


    @endphp



    <script>
        import CustomSelect from "@/components/CustomSelect.vue";

        let Files_Options = {!! json_encode( $options??[] , JSON_HEX_TAG ) !!};


        function Files_onPageDisplay(elm) {
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

        let Files_editor = new $.fn.dataTable.Editor({

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Files_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Files_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Files_web_index')}}/_id_/delete"
                },
                cache: true

            },


            table: '#Files',


            template: '#Files_customForm',
            display: Files_onPageDisplay($('#form_files')),
            fields: [


                {


                    label: " {{!empty($files_editorLabels['old_name'])?$files_editorLabels['old_name']:'Old_name'}}  :",
                    name: "old_name"
                    @if(request()->has('__key__old_name'))
                    ,
                    def: "{{request()->get('__key__old_name')}}"
                    @endif
                },


                {


                    label: " {{!empty($files_editorLabels['new_name'])?$files_editorLabels['new_name']:'New_name'}}  :",
                    name: "new_name"
                    @if(request()->has('__key__new_name'))
                    ,
                    def: "{{request()->get('__key__new_name')}}"
                    @endif
                },


                {


                    label: " {{!empty($files_editorLabels['descriptions'])?$files_editorLabels['descriptions']:'Descriptions'}}  :",
                    name: "descriptions",
                    type: "textarea"
                    @if(request()->has('__key__descriptions'))
                    ,
                    def: "{{request()->get('__key__descriptions')}}"
                    @endif

                },


                {


                    label: " {{!empty($files_editorLabels['extensions'])?$files_editorLabels['extensions']:'Extensions'}}  :",
                    name: "extensions"
                    @if(request()->has('__key__extensions'))
                    ,
                    def: "{{request()->get('__key__extensions')}}"
                    @endif
                },


                {


                    label: " {{!empty($files_editorLabels['size'])?$files_editorLabels['size']:'Size'}}  :",
                    name: "size"
                    @if(request()->has('__key__size'))
                    ,
                    def: "{{request()->get('__key__size')}}"
                    @endif
                },


                {


                    label: " {{!empty($files_editorLabels['path'])?$files_editorLabels['path']:'Path'}}  :",
                    name: "path"
                    @if(request()->has('__key__path'))
                    ,
                    def: "{{request()->get('__key__path')}}"
                    @endif
                },


                {


                    label: " {{!empty($files_editorLabels['web_path'])?$files_editorLabels['web_path']:'Web_path'}}  :",
                    name: "web_path"
                    @if(request()->has('__key__web_path'))
                    ,
                    def: "{{request()->get('__key__web_path')}}"
                    @endif
                },


                {


                    label: " {{!empty($files_editorLabels['statut'])?$files_editorLabels['statut']:'Statut'}}  :",
                    name: "statut",
                    def: '0',
                    type: 'hidden'
                },


                // les parents2


            ],
        });


        Files_editor.on('preOpen', function () {
            $('#form_files').addClass('card')
            $('#files_app_vue').hide()

        })
        Files_editor.on('close', function () {
            $('#form_files').removeClass('card')
            $('#files_app_vue').show()


        })
        Files_editor.on('processing', function (e, processing) {
            if (processing) {
                $('body').addClass('processingBody')

            } else {
                $('body').removeClass('processingBody')

            }
        })

        Files_editor.on('preOpen', function () {

        })
        Files_editor.on('open', function () {
            console.log('on ouvre le formulaire')
            console.log('on veut deplacer  le formulaire')
            $('.DTE_Form_Buttons .btn:eq(0)').addClass('btn-primary');
            $('.DTE_Form_Buttons .btn:eq(1)').addClass('btn-danger');
            $('#Files_parents').hide()
        })
        Files_editor.on('initSubmit', function (editor) {
            console.log('je mapprete a soumettre les donnees')


            @foreach($preselect as $key=>$value)
            Files_editor.field("{{$key}}").set("{{$value}}")
            @endforeach
        })
        Files_editor.on('submitSuccess', function () {
            console.log('je recharge les donnees')
            location.reload()
        })
        Files_editor.on('close', function () {
            $('#Files_parents').show()


        })


    </script>




    <script>
        import CustomSelect from "@/components/CustomSelect.vue";

        let donnes = [{!! json_encode($Files, JSON_HEX_TAG) !!}];
        $(`#loader_files`).css('display', 'none')


        let Files_table = $('#Files').DataTable({

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
                        if (filesrender.indexOf('id') != -1) {
                            let template = Handlebars.compile(filesrender['id']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },
                // {data: 'PipelinesAvf'},


                // la donnee id  {data: 'id'},
// la donnee label

                {
                    data: 'old_name', render: function (data, type, row) {
                        let rendered = data

                        if (filesrender.indexOf('old_name') != -1) {
                            let template = Handlebars.compile(filesrender['old_name']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },


                {
                    data: 'new_name', render: function (data, type, row) {
                        let rendered = data

                        if (filesrender.indexOf('new_name') != -1) {
                            let template = Handlebars.compile(filesrender['new_name']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },


                {
                    data: 'descriptions', render: function (data, type, row) {
                        let rendered = data

                        if (filesrender.indexOf('descriptions') != -1) {
                            let template = Handlebars.compile(filesrender['descriptions']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },


                {
                    data: 'extensions', render: function (data, type, row) {
                        let rendered = data

                        if (filesrender.indexOf('extensions') != -1) {
                            let template = Handlebars.compile(filesrender['extensions']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },


                {
                    data: 'size', render: function (data, type, row) {
                        let rendered = data

                        if (filesrender.indexOf('size') != -1) {
                            let template = Handlebars.compile(filesrender['size']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },


                {
                    data: 'path', render: function (data, type, row) {
                        let rendered = data

                        if (filesrender.indexOf('path') != -1) {
                            let template = Handlebars.compile(filesrender['path']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },


                {
                    data: 'web_path', render: function (data, type, row) {
                        let rendered = data

                        if (filesrender.indexOf('web_path') != -1) {
                            let template = Handlebars.compile(filesrender['web_path']);
                            rendered = template({data: data, all: row});


                        }
                        return rendered;
                    }
                },


                {
                    data: 'CreateursRender', render: function (data, type, row) {
                        let rendered = data
                        if (filesrender.indexOf('CreateursRender') != -1) {

                            let template = Handlebars.compile(filesrender['CreateursRender']);
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


        $('#files-row-edit').on('click', function (e) {

            let tr = {!! json_encode($Files, JSON_HEX_TAG) !!};


            Files_editor.field('createurs').hide()


            Files_editor.edit(tr, {
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
        $('#files-row-delete').on('click', function (e) {


            let tr = {!! json_encode($Files, JSON_HEX_TAG) !!};


            Files_editor.remove(tr, {
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
