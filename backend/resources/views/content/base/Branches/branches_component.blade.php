@php

    use App\Models\prod\Tables_formulairesModel;use Illuminate\Support\Facades\DB;$__internalId__=request()->get('__internalId__');

    $brancheslabels=DB::table('tables_labels')->where('tables','branches')->get();
    $hide=DB::table('tables_labels')->where('tables','branches')->where('cacher','oui')
    ->get()
    ->map(function($data){
        return $data->nouveau;
    });
    $branchesrender=[];
    foreach ($brancheslabels->toArray() as $cha){
        if(!empty($cha->render) && $cha->render!='false'){
                $branchesrender[$cha->ancien]=$cha->render;


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


<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
<link href="{{asset(mix('css/personnal/editor/editor_beau_formulaire.css'))}}" rel="stylesheet" type="text/css">
<link href="{{asset(mix('css/personnal/admin/admin.css'))}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/tables/datatables.searchHighLight.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/tables/select.datatables.css')) }}">


@livewireStyles


@if($branches_disposition->disposition=="Grid")
    <style>

        #Branches_{{$__internalId__}} thead {
            display: none !important;
        }

        #Branches_{{$__internalId__}} tbody {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px
        }

        #Branches_{{$__internalId__}} tbody tr {
            background: none !important;
            border: 1px solid #d5d0d0;
            border-radius: 5px;
            display: flex;
            justify-content: center;
        }

    </style>
@endif






<script>

    let hideColumnsbranches_{{$__internalId__}}= {!! json_encode($hide, JSON_HEX_TAG) !!};
    let branchesrender_{{$__internalId__}} = {!! json_encode($branchesrender, JSON_HEX_TAG) !!};
</script>


<div id='app' class="">

    <div id='form_branches_{{$__internalId__}}'></div>


    <div id='Branches_{{$__internalId__}}_app_vue' v-show='show_table'>


        <div class="col-md-12 ">
            <div class="col-sm-12 heading-bg">
                <div class="card panel-heading" id="Branches_{{$__internalId__}}_tables_boutons">

                </div>

                <div class="card">
                    <div id='loader_branches_{{$__internalId__}}' class="loader_page"
                         style="display:flex;flex-direction: column">
                        <div class="spinner-border text-light" role="status"></div>
                        <span class="" style="color: #fff">Loading...</span></div>
                    <div class="card-header">
                        Les branches


                        @if((!request()->has('crud') || intval(request()->get('crud'))!=0) && $branches_disposition->disposition!="Component")
                            @if(auth()->user()->hasPermissionTo('Creer tous les branches'))
                                <i id="new_branches_{{$__internalId__}}"
                                   class="fa fa-plus btn btn-light fas fa-plus font-weight-bold waves-effect waves-float waves-light "
                                   style="float: right"></i>
                            @endif
                        @endif
                    </div>
                    <div class="card-body">
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


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
        }
    });


</script>
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.select.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>

<script src="{{asset('vendors/js/tables/datatable/dataTables.editor.min.js')}}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/ckeditor/ckeditor.complet.min.js')) }}"></script>
<script src="{{ asset(mix('js/personnal/editor/editor_personnal_field.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/RowReorder/dataTables.rowReorder.min.js')) }}"></script>


@livewireScripts
<script src="{{ asset(mix('vendors/js/vuejs/vue2.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/jquery/jquery.hightlight.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/search.hightlight.min.js')) }}"></script>


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


    function Branches_getEditor_{{$__internalId__}}(elm) {

        Branches_customForm_id = 'Branches' + Date.now()
        let Branches_customFormElement = $('#Branches_{{$__internalId__}}_customForm').clone().attr('id', Branches_customForm_id)

        $('#form_branches_{{$__internalId__}}').empty()
        $('#form_branches_{{$__internalId__}}').append(Branches_customFormElement)


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


            template: '#' + Branches_customForm_id,
            display: Branches_onPageDisplay_{{$__internalId__}}(elm),
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
                    type: "select1",
                    entite: 'users'
                    @if(request()->has('__key__createurs'))
                    ,
                    def: "{{request()->get('__key__createurs')}}"
                    @endif

                },


                // les parents1


            ],
        }


        $('#form_branches_{{$__internalId__}}')
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
            @if($branches_disposition->disposition=="Component")


            @else
            $('#form_branches_{{$__internalId__}}').addClass('card')
            $('#Branches_{{$__internalId__}}_app_vue').hide()

            @endif


        })
        Branches_editor_{{$__internalId__}}.on('close', function () {

            @if($branches_disposition->disposition=="Component")


            @else
            $('#form_branches_{{$__internalId__}}').removeClass('card')
            $('#Branches_{{$__internalId__}}_app_vue').show()

            @endif




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
            console.log('on ouvre le formulaire')
            console.log('on veut deplacer  le formulaire 2')
            $('.DTE_Form_Buttons').each(function () {
                $(this).find('.btn:eq(0)').addClass('btn-primary');
                $(this).find('.btn:eq(1)').addClass('btn-danger');
            });

            @if($branches_disposition->disposition=="Component")


            @else
            $('#Branches_{{$__internalId__}}_parents').hide()

            @endif

        })
        Branches_editor_{{$__internalId__}}.on('initSubmit', function (editor) {
            console.log('je mapprete a soumettre les donnees')
            @foreach($preselect as $key=>$value)
            Branches_editor_{{$__internalId__}}.field("{{$key}}").set("{{$value}}")
            @endforeach
        })
        Branches_editor_{{$__internalId__}}.on('submitSuccess', function () {
            console.log('je recharge les donnees')
            toastr['success'](`Traitement effectuer avec succes`, 'Succes', {
                positionClass: 'toast-top-right',
                tapToDismiss: false,
                rtl: true
            });
        })
            .on('submitComplete', function (e, f) {
                console.log('je recharge les donnees', e, f)
                if (f.hasOwnProperty('message')) {
                    // e.close()
                    toastr['warning'](f.message, 'error', {
                        positionClass: 'toast-top-right',
                        tapToDismiss: false,
                        rtl: true
                    });
                }
            })
        Branches_editor_{{$__internalId__}}.on('close', function () {
            @if($branches_disposition->disposition=="Component")


            @else
            $('#Branches_{{$__internalId__}}_parents').show()

            @endif



        })

        return Branches_editor_{{$__internalId__}}

    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";


    let Branches_table_{{$__internalId__}} = $('#Branches_{{$__internalId__}}').DataTable({

        @if(request()->get('pkey') && request()->get('pval')  )
        ajax: {
            url: " {{ URL::signedRoute('Branches_web_index_data2',
            [
                'key'=> request()->get('pkey'),'val'=>request()->get('pval')]) }}",
            type: 'POST',
            cache: true

        }
        ,
        @elseif(!empty($Branches)   )
        ajax: {
            url: " {{ URL::signedRoute('Branches_web_index_data2',
            [
                'key'=> 'id','val'=>$Branches->id]) }}",
            type: 'POST',
            cache: true

        }
        ,
        @else
        ajax: {
            url: "{{ route('Branches_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        @endif


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
        dom: 'ltBip',

        responsive: true,
        deferRender: true,
        buttons: [

                @if($branches_disposition->disposition=="Component")
            {
                extend: 'create',
                text: "Nouveau",
                action: function (e, dt, node, config) {
                    let _body_element = $(dt.table().body())
                    _body_element.nextAll().remove()
                    let div = $('<div style="padding: 10px"></div>')
                    _body_element.after(div)
                    BranchesNew(div)

                }
            },

            @endif


        ],
        columns: [

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


                    }
                    return rendered;
                }
            },


            {
                data: 'CardRender', render: function (data, type, row) {
                    let rendered = data

                    if ('CardRender' in branchesrender_{{$__internalId__}}.indexOf) {
                        let template = Handlebars.compile(branchesrender['CardRender']);
                        rendered = template({data: data, all: row});


                    }
                    return rendered;
                }
            },
            {
                data: 'CardRenderComponent', render: function (data, type, row) {
                    let rendered = data

                    if ('CardRenderComponent' in branchesrender_{{$__internalId__}}.indexOf) {
                        let template = Handlebars.compile(branchesrender['CardRenderComponent']);
                        rendered = template({data: data, all: row});


                    }
                    return rendered;
                }
            },
            {
                data: 'CardRenderSelect', render: function (data, type, row) {
                    let rendered = data


                    if ('CardRenderSelect' in branchesrender_{{$__internalId__}}.indexOf) {
                        let template = Handlebars.compile(branchesrender['CardRenderSelect']);
                        rendered = template({data: data, all: row});


                    }
                    return rendered;
                }
            },
            {
                data: null, render: function (data, type, row) {
                    return `

                    @if(!request()->has('imprimer') || intval(request()->get('impression'))!=0)
                    <a href='${data.SignedImpressionUrl}'>
                        <button class='btn text-dark p-0 text-center' ><i class='fas fa-print'></i></button>
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
        processing: true,
        serverSide: true
    });
    Branches_table_{{$__internalId__}}.on('processing', function (e, settings, processing) {
        if (processing) {
            // $('body').addClass('processingBody')
            $(`#loader_branches_{{$__internalId__}}`).css('display', 'flex')

        } else {
            $(`#loader_branches_{{$__internalId__}}`).css('display', 'none')

            // $('body').removeClass('processingBody')

        }
    })
    if ($('#Branches_{{$__internalId__}}_rechercheDatatables').val()) {
        Branches_table_{{$__internalId__}}.search($('#Branches_{{$__internalId__}}_rechercheDatatables').val()).draw();

    }
    let Timer_Branches_{{$__internalId__}};
    $('#Branches_{{$__internalId__}}_rechercheDatatables').keydown(function () {
        clearTimeout(Timer_Branches_{{$__internalId__}})
        Timer_Branches_{{$__internalId__}} = setTimeout(function () {
            console.log('je demarre la recherche', $('#Branches_{{$__internalId__}}_rechercheDatatables').val())
            Branches_table_{{$__internalId__}}.search($('#Branches_{{$__internalId__}}_rechercheDatatables').val()).draw();
        }, 3000);

    })


    Branches_table_{{$__internalId__}}.on('draw', function () {
        console.log('on draw')
        var body = $(Branches_table_{{$__internalId__}}.table().body());
        window.livewire.rescan()
        var column = Branches_table_{{$__internalId__}}.columns();
        var column = column[0];

        // console.log(hideColumns)
        column.forEach(function (data) {
            let singleton = Branches_table_{{$__internalId__}}.column(data)

            if (hideColumnsbranches_{{$__internalId__}}.indexOf(singleton.header().textContent.toLowerCase()) != -1) {
                singleton.visible(false)
            }

        })


        @if($branches_disposition->disposition=="Grid")

        column.forEach(function (data) {
            let singleton = Branches_table_{{$__internalId__}}.column(data)
            if (singleton.header().textContent.toLowerCase() != "CardRender".toLowerCase()) {
                singleton.visible(false)
            }

        })

        @elseif($branches_disposition->disposition=="Component")

        column.forEach(function (data) {
            let singleton = Branches_table_{{$__internalId__}}.column(data)
            if (singleton.header().textContent.toLowerCase() != "CardRenderComponent".toLowerCase()) {
                singleton.visible(false)
            }

        })

        @elseif($branches_disposition->disposition=="Select")

        column.forEach(function (data) {
            let singleton = Branches_table_{{$__internalId__}}.column(data)
            if (singleton.header().textContent.toLowerCase() != "CardRenderSelect".toLowerCase()) {
                singleton.visible(false)
            }

        })

        @else

        column.forEach(function (data) {
            let singleton = Branches_table_{{$__internalId__}}.column(data)
            if (singleton.header().textContent.toLowerCase() == "CardRender".toLowerCase()
                || singleton.header().textContent.toLowerCase() == "CardRenderComponent".toLowerCase()
                || singleton.header().textContent.toLowerCase() == "CardRenderSelect".toLowerCase()
            ) {
                singleton.visible(false)
            }

        })
        @endif

        body.unhighlight();
        if (Branches_table_{{$__internalId__}}.rows({filter: 'applied'}).data().length) {
            body.highlight(Branches_table_{{$__internalId__}}.search());
        }
    });


    // Activate an inline edit on click of a table cell
    $('#Branches_{{$__internalId__}}').on('click', '.row-edit', function (e) {
        let _body_element = $(Branches_table_{{$__internalId__}}.table().body())
        _body_element.find('.form_element_child').empty()
        _body_element.nextAll().empty()
        _body_element.nextAll().remove()
        let parent = $($(this).closest("tr"))
        let tr;
        if (parent.hasClass('child')) {

            tr = parent.prev()
        } else {
            tr = parent
        }


        // debut de linitiatialisation de lediteur

        @if($branches_disposition->disposition=="Component")
        tr.find('.form_element_child').empty()
        tr.find('.form_element_child').show()
        tr.find('.form_element_next').hide()


        let Branches_editor_{{$__internalId__}}= Branches_getEditor_{{$__internalId__}}(tr.find('.form_element_child'))
        @else
        let Branches_editor_{{$__internalId__}}= Branches_getEditor_{{$__internalId__}}($('#form_branches_{{$__internalId__}}'))


        @endif






















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
    $('#Branches_{{$__internalId__}}').on('click', '.row-delete', function (e) {
        let _body_element = $(Branches_table_{{$__internalId__}}.table().body())
        _body_element.find('.form_element_child').empty()
        _body_element.nextAll().empty()
        _body_element.nextAll().remove()
        let parent = $($(this).closest("tr"))
        let tr;
        if (parent.hasClass('child')) {

            tr = parent.prev()
        } else {
            tr = parent
        }

        @if($branches_disposition->disposition=="Component")
        tr.find('.form_element_child').empty()
        tr.find('.form_element_child').show()
        tr.find('.form_element_next').hide()

        let Branches_editor_{{$__internalId__}}= Branches_getEditor_{{$__internalId__}}(tr.find('.form_element_child'))
        @else
        let Branches_editor_{{$__internalId__}}= Branches_getEditor_{{$__internalId__}}($('#form_branches_{{$__internalId__}}'))


        @endif

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
    $('#Branches_{{$__internalId__}}').on('click', '.row-switch', function (e) {

        let parent = $($(this).parents("tr"))
        let tr;
        if (parent.hasClass('child')) {

            tr = parent.prev()
        } else {
            tr = parent
        }


        tr.find('.form_element_child').hide()
        tr.find('.form_element_next').toggle()

    })
    $('#Branches_{{$__internalId__}}').on('click', '.row-child', function (e) {
        // alert('on veut aller cher un enfants')
        //
        // let actualEntite=$(this).attr('data-attr-entites')
        // let dataAttrEntites=$(this).attr('data-attr-entites')
        // let dataAttrParentsKey=$(this).attr('data-attr-parents-key')
        // let dataAttrParentsVal=$(this).attr('data-attr-parents-val')
        // let dataAttrUrl=$(this).attr('data-attr-url')
        //
        //
        // let parent = $($(this).parents("tr"))
        // let tr;
        // if (parent.hasClass('child')) {
        //
        //     tr = parent.prev()
        // } else {
        //     tr = parent
        // }
        //
        //
        //
        // console.log('voici le  parents',tr,data)
        // let parentsElement=$(data.CardRenderComponent)
        // parentsElement.find('.form_element_child').empty()
        // parentsElement.find('.form_element_next').empty()
        // parentsElement.find('.all_buttons').empty()


    });


    function BranchesNew(elem) {
        let Branches_editor_{{$__internalId__}}= Branches_getEditor_{{$__internalId__}}(elem)


        Branches_editor_{{$__internalId__}}.field('createurs').show()


        Branches_editor_{{$__internalId__}}.create().buttons([
            'Creer',
            {
                text: 'Annuler', action: function () {
                    this.close();
                }
            }
        ]).open();
    }


    $('#new_branches_{{$__internalId__}}').on('click', function (e) {
        BranchesNew($('#form_branches_{{$__internalId__}}'))

    });
    $('.buttons-create').addClass('btn btn-primary');
    $('.buttons-edit').addClass('btn btn-warning');
    $('.buttons-remove').addClass('btn btn-danger');


</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    $('.tab-content').append($('.tab-extra'))
</script>

