@php

    use App\Models\prod\Tables_formulairesModel;use Illuminate\Support\Facades\DB;$__internalId__=request()->get('__internalId__');

    $sectionslabels=DB::table('tables_labels')->where('tables','sections')->get();
    $hide=DB::table('tables_labels')->where('tables','sections')->where('cacher','oui')
    ->get()
    ->map(function($data){
        return $data->nouveau;
    });
    $sectionsrender=[];
    foreach ($sectionslabels->toArray() as $cha){
        if(!empty($cha->render) && $cha->render!='false'){
                $sectionsrender[$cha->ancien]=$cha->render;


        }
    }

    $forms=Tables_formulairesModel::where('tables','sections')->get();
    if(!empty($forms->first()->disposition)){
        $forms=explode('_//_',$forms->first()->disposition);
    }else{
        $forms=[];
    }
    $newForms=[];
    foreach ($forms as $form){
        $newForms[]=explode('_/_',$form);
    }
    function getLabelSections($label,$labels){
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
    <link href="{{asset(mix('css/personnal/editor/editor_beau_formulaire.css'))}}" rel="stylesheet" type="text/css">
    <link href="{{asset(mix('css/personnal/admin/admin.css'))}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/tables/datatables.searchHighLight.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/tables/select.datatables.css')) }}">
    {{--    <link rel="stylesheet" href="{{ asset('web-components/public/HTML/css/bootstrap.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('web-components/public/HTML/css/font-icons.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.13/dist/vue.js"></script>
    @livewireStyles


    @if($sections_disposition->disposition=="Grid")
        <style>

            #Sections_{{$__internalId__}} thead {
                display: none !important;
            }

            #Sections_{{$__internalId__}} tbody {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px
            }

            #Sections_{{$__internalId__}} tbody tr {
                width: 300px;
                background: none !important;
                border: 1px solid #d5d0d0;
                border-radius: 5px;
                display: flex;
                justify-content: center;
            }

        </style>
    @endif
    @if($sections_disposition->disposition=="Component")
        <style>

            #Sections_{{$__internalId__}} thead {
                display: none !important;
            }

            #Sections_{{$__internalId__}} tbody .row-switch {
                display: none !important;
            }

            #Sections_{{$__internalId__}}_parents .dt-buttons {
                margin: 0 auto;
                width: 90%;
                display: block;
                justify-content: center;
                text-align: center;
            }


        </style>
    @endif
    <style>

        #Components_{{$__internalId__}} thead {
            display: none !important;
        }

        #Components_{{$__internalId__}}_parents .dt-buttons {
            margin: 0 auto;
            width: 90%;
            display: block;
            justify-content: center;
            text-align: center;
        }


    </style>

@endsection

@section('title',"sections")
@section('content')

    <script>

        let hideColumnssections = {!! json_encode($hide, JSON_HEX_TAG) !!};
        let sectionsrender = {!! json_encode($sectionsrender, JSON_HEX_TAG) !!};
    </script>



    <div id='app' class="row">


        <div class="col-sm-4">

            <div id='form_sections_{{$__internalId__}}'></div>
            <div id='Sections_{{$__internalId__}}_app_vue' v-show="etat=='Listes'">
                <div class="col-md-12 ">
                    <div class="col-sm-12 heading-bg">
                        <div class="card panel-heading" id="Sections_{{$__internalId__}}_tables_boutons">

                        </div>

                        <div class="card">
                            <div id='loader_sections_{{$__internalId__}}' class="loader_page"
                                 style="display:flex;flex-direction: column">
                                <div class="spinner-border text-light" role="status"></div>
                                <span class="" style="color: #fff">Loading...</span></div>
                            <div class="card-header">
                                Les sections


                                @if((!request()->has('crud') || intval(request()->get('crud'))!=0) && $sections_disposition->disposition!="Component")
                                    @if(auth()->user()->hasPermissionTo('Creer tous les sections'))
                                        <i id="new_sections_{{$__internalId__}}"
                                           class="fa fa-plus btn btn-light fas fa-plus font-weight-bold waves-effect waves-float waves-light "
                                           style="float: right"></i>
                                    @endif
                                @endif
                            </div>
                            <div class="card-body">
                                <input id="Sections_{{$__internalId__}}_rechercheDatatables" type="text"
                                       class="InputRechercheDatatable  form-control"
                                       placeholder="Entrez votre recherche">

                                <div id="Sections_{{$__internalId__}}_parents" class='tables'>

                                    <table id='Sections_{{$__internalId__}}' class='display table table-striped'
                                           style='width:100%'>


                                        <thead
                                                @if($sections_disposition->disposition=="Component")
                                                    style="display: none"

                                                @endif
                                        >
                                        <tr>
                                            <th></th>


                                            <th>{{getLabelSections('Name',$sectionslabels)}}</th>


                                            <th>{{getLabelSections('ComponentIdRender',$sectionslabels)}}</th>


                                            <th>{{getLabelSections('PageIdRender',$sectionslabels)}}</th>


                                            <th>{{getLabelSections('CreateursRender',$sectionslabels)}}</th>


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

            <div id='Components_{{$__internalId__}}_app_vue' v-show="etat=='Create'">


                <div class="col-md-12 ">
                    <div class="col-sm-12 heading-bg">
                        <div class="card panel-heading" id="Components_{{$__internalId__}}_tables_boutons">

                        </div>

                        <div class="card">
                            <div id='loader_components_{{$__internalId__}}' class="loader_page"
                                 style="display:flex;flex-direction: column">
                                <div class="spinner-border text-light" role="status"></div>
                                <span class="" style="color: #fff">Loading...</span></div>
                            <div class="card-header">
                                Les components

                            </div>
                            <div class="card-body">
                                <input id="Components_{{$__internalId__}}_rechercheDatatables" type="text"
                                       class="InputRechercheDatatable  form-control"
                                       placeholder="Entrez votre recherche">

                                <div id="Components_{{$__internalId__}}_parents" class='tables'>

                                    <table id='Components_{{$__internalId__}}' class='display table table-striped'
                                           style='width:100%'>


                                        <thead style="display: none">
                                        <tr>
                                            <th></th>


                                        </tr>
                                        </thead>
                                        <tbody class="select1-body"></tbody>

                                    </table>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <div id="rendu" class="col-sm-8">
            <h1>Voici le rendu</h1>
        </div>

    </div>




    <div class="container" id="appElement">
        <h4>Voici le parents</h4>

    </div>


    <div style="display:none">
        <div id='Sections_{{$__internalId__}}_customForm' style="">
            <div class="card-header">
                @if(!empty($sections_disposition->form_text) && $sections_disposition->form_text!='false' )
                    {!! $sections_disposition->form_text !!}
                @else
                    <h6 class="card-title"><i class="fa fa-user-md"></i> Manage Sections</h6>
                @endif
            </div>
            <div class="card-body">
                <div class="row">


                    @php
                        $sections_labForm=[];

                    foreach($sectionslabels as $lab){
                    if(!empty($lab->class) && $lab->class!='false'){
                                $sections_labForm[$lab->ancien]=$lab->class??'col-sm-12';

                    }else{
                    $sections_labForm[$lab->ancien]='col-sm-12';
                    }
                    }


                    @endphp


                    <div class='{{$sections_labForm['name']??"col-sm-12"}}' data-editor-template='name'></div>


                    <div class='{{$sections_labForm['css']??"col-sm-12"}}' data-editor-template='css'></div>


                    <div class='{{$sections_labForm['media_query']??"col-sm-12"}}'
                         data-editor-template='media_query'></div>


                    <div class='{{$sections_labForm['statut']??"col-sm-12"}}' data-editor-template='statut'></div>


                    <div class='col-sm-12' data-editor-template='component_id'></div>


                    <div class='col-sm-12' data-editor-template='page_id'></div>


                </div>
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
    @livewireScripts
    {{--    <script src="{{ asset(mix('vendors/js/vuejs/vue2.min.js')) }}"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.13/dist/vue.js"></script>
    <script src="{{ asset(mix('vendors/js/jquery/jquery.hightlight.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/search.hightlight.min.js')) }}"></script>
    <script src="{{ asset('web-components/public/HTML/js/plugins.min.js') }}"></script>
    <script src="{{ asset('web-components/public/HTML/js/functions.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>








    @php
        $sections_editorLabels=[];

    foreach($sectionslabels as $lab){
    if(!empty($lab->editor_labels) && $lab->editor_labels!='false'){
    $sections_editorLabels[$lab->ancien]=$lab->editor_labels??'';
    }else{
    $sections_editorLabels[$lab->ancien]='';

    }

    }


    @endphp





    <script>

        let vm = new Vue({
            el: '#app',
            data: {
                etat: 'Listes',
                elements: []
            },
            mounted() {

                let that = this
                let Sections_Options = {!! json_encode( $options??[] , JSON_HEX_TAG ) !!};


                function Sections_onPageDisplay(elm) {
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


                function Sections_getEditor(elm) {

                    Sections_customForm_id = 'Sections' + Date.now()
                    let Sections_customFormElement = $('#Sections_{{$__internalId__}}_customForm').clone().attr('id', Sections_customForm_id)

                    $('#form_sections_{{$__internalId__}}').empty()
                    $('#form_sections_{{$__internalId__}}').append(Sections_customFormElement)


                    let Sections_editor_config = {

                        ajax: {
                            create: {
                                type: 'POST',
                                url: "{{ URL::signedRoute('Sections_web_create') }}"
                            },
                            edit: {
                                type: 'POST',
                                url: "{{route('Sections_web_index')}}/_id_/update",
                            },

                            remove: {
                                type: 'POST',
                                url: "{{route('Sections_web_index')}}/_id_/delete"
                            },
                            cache: true

                        },


                        table: '#Sections_{{$__internalId__}}',


                        template: '#' + Sections_customForm_id,
                        display: Sections_onPageDisplay(elm),
                        fields: [


                            {


                                label: " {{!empty($sections_editorLabels['name'])?$sections_editorLabels['name']:'Name'}}  :",
                                name: "name"
                                @if(request()->has('__key__name'))
                                ,
                                def: "{{request()->get('__key__name')}}"
                                @endif
                            },


                            {


                                label: " {{!empty($sections_editorLabels['css'])?$sections_editorLabels['css']:'Css'}}  :",
                                name: "css",
                                type: "repeat",
                                class: 'col-sm-12 order-99',
                                champs: [
                                    {
                                        label: "Attribut:", name: "attribut", type: 'selectperso',
                                        options: [
                                            {'label': 'MARGIN', 'value': 'margin'},
                                            {'label': 'COLOR', 'value': 'color'},
                                            {'label': 'BACKGROUND IMAGE', 'value': 'background-image'}
                                        ]
                                    },
                                    {label: " Text :", name: "text"},
                                    {label: " color :", name: "color", type: "color"},
                                    {label: " Images :", name: "images", type: "images"},

                                ],
                                render: function (data) {
                                    return data.attribut
                                },
                                after: function (editor, datatable) {
                                    editor.dependent('attribut', function (val) {
                                        let retour = {}
                                        console.log('voici le changement', val)

                                        if (val && val == 'margin') {
                                            retour['show'] = ['attribut', 'text']
                                            retour['hide'] = ['color', 'images']


                                        } else if (val && val == 'color') {
                                            retour['show'] = ['attribut', 'color']
                                            retour['hide'] = ['text', 'images']


                                        } else if (val && val == 'background-image') {
                                            retour['show'] = ['attribut', 'images']
                                            retour['hide'] = ['text', 'color']


                                        } else {
                                            retour['show'] = ['text']
                                            retour['hide'] = ['color', 'images']
                                        }
                                        return retour
                                    })
                                }
                                @if(request()->has('__key__css'))
                                ,
                                def: "{{request()->get('__key__css')}}"
                                @endif
                            },


                            {


                                label: " {{!empty($sections_editorLabels['media_query'])?$sections_editorLabels['media_query']:'Media_query'}}  :",
                                name: "media_query",
                                type: "repeat",
                                class: 'col-sm-12 order-99',
                                champs: [
                                    {label: "Min:", name: "min", class: 'col-sm-6 order-01'},
                                    {label: "Max:", name: "max", class: 'col-sm-6 order-01'},
                                    {
                                        label: "Css  :",
                                        name: "css",
                                        type: "repeat",

                                        champs: [
                                            {
                                                label: "Attribut:", name: "attribut", type: 'selectperso',
                                                options: [
                                                    {'label': 'MARGIN', 'value': 'margin'},
                                                    {'label': 'COLOR', 'value': 'color'},
                                                    {'label': 'BACKGROUND IMAGE', 'value': 'background-image'}
                                                ]
                                            },
                                            {label: " Text :", name: "text"},
                                            {label: " color :", name: "color", type: "color"},
                                            {label: " Images :", name: "images", type: "images"},

                                        ],
                                        render: function (data) {
                                            return data.attribut
                                        },
                                        after: function (editor, datatable) {
                                            editor.dependent('attribut', function (val) {
                                                let retour = {}
                                                console.log('voici le changement', val)

                                                if (val && val == 'margin') {
                                                    retour['show'] = ['attribut', 'text']
                                                    retour['hide'] = ['color', 'images']


                                                } else if (val && val == 'color') {
                                                    retour['show'] = ['attribut', 'color']
                                                    retour['hide'] = ['text', 'images']


                                                } else if (val && val == 'background-image') {
                                                    retour['show'] = ['attribut', 'images']
                                                    retour['hide'] = ['text', 'color']


                                                } else {
                                                    retour['show'] = ['text']
                                                    retour['hide'] = ['color', 'images']
                                                }
                                                return retour
                                            })
                                        }

                                    },


                                ],
                                render: function (data) {
                                    if (data.css.length > 1) {
                                        return `${data.min}  de  ${data.max} ( ${data.css.length} regles ) `

                                    } else {
                                        return `${data.min}  de  ${data.max} ( ${data.css.length} regle ) `

                                    }
                                },
                            },

                            {


                                label: " Structures  :",
                                name: "structures"

                            },


                        ],
                    }


                    $('#form_sections_{{$__internalId__}}')
                    let Sections_editor = new $.fn.dataTable.Editor(Sections_editor_config);

                    function prefixCss(prefix, cssString) {

                        let doc = document.implementation.createHTMLDocument("")
                        let styleElement = document.createElement("style")
                        styleElement.textContent = cssString;
                        // the style will only be parsed once it is added to a document
                        doc.body.appendChild(styleElement)

                        let styles = [...doc.styleSheets]
                        let allInlineCss = [];
                        styles.forEach(data => {
                            let cssRules = [...data.cssRules]
                            cssRules.forEach(don => {
                                allInlineCss.push(don.cssText)
                            })
                        })
                        allInlineCss = allInlineCss.map(data => {
                            return `#${prefix} ` + data
                        })
                        let allInlineCssRender = allInlineCss.join(' \n')

                        return allInlineCssRender
                    }

                    function prefixScript(scripString) {

                        let doc = document.implementation.createHTMLDocument("")
                        let scriptElement = document.createElement("script")
                        // the script will only be parsed once it is added to a document
                        doc.body.innerHTML = ""
                        doc.body.appendChild(scriptElement)
                        console.log('voici le document', doc.scripts[0].textContent)


                    }

                    Sections_editor.dependent('structures', function (val) {
                        let retour = {}

                        // $.ajax({
                        //     url:filesUrl,
                        // }).done(function( data ) {
                        //     console.log('data',data)
                        //     let newData1
                        //     let script=data.replace('export default',"newData1=")

                        if (val) {
                            let data = val
                            let newId = "Text_" + "" + Date.now()


                            // console.log('data', data)
                            let newData1 = {}
                            let script = data.replace('export default', `let ${newId}=`)
                            script = script.replace(' ', `\\n`)

                            console.log('voici la structures', script)
                            eval(script)


                            // newData1.name = 'text'
                            // console.log(script, newData1);
                            let newCss = prefixCss(newData1.name, newData1.style)
                            newData1.template = `<div id="${newData1.name}"> ${newData1.template}</div>`
                            if (!$(`style[data-src-id=${newData1.name}]`).length) {
                                let cssRender = $("<style>")
                                    .attr('data-src-id', newData1.name)
                                    .prop("type", "text/css")
                                $('head').append(cssRender)
                            }
                            $(`style[data-src-id=${newData1.name}]`).text(newCss)

                            //
                            // console.log('voici lobjet de configuration',newData1)
                            //
                            //
                            //
                            // $("#appElement").empty()
                            //
                            // let element= new Vue({el:'#appElement',...newData1})
                            // window.ele=element
                            // let i=16
                            // let structures=newData1.champs
                            // structures=structures.map(dat=>{
                            //
                            //     dat.class="col-sm-12 order-"+i
                            //     i++
                            //     return dat
                            // })
                            // console.log('voici les champs',Sections_editor.order())
                            //
                            // let champsSuppimer=Sections_editor.order().filter(data=>{
                            //     let base=[
                            //         'id',
                            //         'statut',
                            //         'page_id',
                            //         'component_id',
                            //         'name',
                            //         'width',
                            //         'css',
                            //         'media_query',
                            //         '__ID__',
                            //         'dataComponents',
                            //     ]
                            //     return base.indexOf(data)==-1
                            // })
                            // Sections_editor.clear(champsSuppimer)
                            // champsSuppimer.forEach(data=>{
                            //     let oldTemplate=Sections_editor.template()
                            //     oldTemplate.find('.card-body').find('.row').find(`[data-editor-template="${data}"]`).remove()
                            //
                            // })
                            // console.log('voici les champs',Sections_editor.order())
                            //
                            // let newId="Text_"+ "" + Date.now()
                            // let form = $(`<div id='form_${newId}' style="display:none"></div>`)
                            // structures.forEach(data=>{
                            //     let oldTemplate=Sections_editor.template()
                            //     let classe='col-sm-12 order-99'
                            //     if(data.class){
                            //         classe=data.class
                            //
                            //     }
                            //     let el=$(` <div class='${classe}' data-editor-template='${data.name}'></div>`)
                            //     oldTemplate.find('.card-body').find('.row').find('[data-editor-template="css"]').before(el)
                            // })
                            // Sections_editor.add(structures)
                            // console.log( "voici les donnees:", structures );


                        } else {
                            let champsSuppimer = Sections_editor.order().filter(data => {
                                let base = [
                                    'id',
                                    'statut',
                                    'page_id',
                                    'component_id',
                                    'name',
                                    'width',
                                    'css',
                                    'media_query',
                                    '__ID__',
                                    'dataComponents',
                                ]
                                return base.indexOf(data) == -1
                            })
                            Sections_editor.clear(champsSuppimer)
                            champsSuppimer.forEach(data => {
                                let oldTemplate = Sections_editor.template()
                                oldTemplate.find('.card-body').find('.row').find(`[data-editor-template="${data}"]`).remove()

                            })

                        }


                        return retour
                    })

                    Sections_editor.on('preOpen', function () {
                        @if($sections_disposition->disposition=="Component")


                        @else
                        $('#form_sections_{{$__internalId__}}').addClass('card')
                        $('#Sections_{{$__internalId__}}_app_vue').hide()

                        @endif


                    })
                    Sections_editor.on('close', function () {

                        @if($sections_disposition->disposition=="Component")


                        @else
                        $('#form_sections_{{$__internalId__}}').removeClass('card')
                        $('#Sections_{{$__internalId__}}_app_vue').show()

                        @endif




                    })
                    Sections_editor.on('processing', function (e, processing) {
                        // if (processing) {
                        //     $('body').addClass('processingBody')
                        //
                        // } else {
                        //     $('body').removeClass('processingBody')
                        //
                        // }
                    })

                    Sections_editor.on('preOpen', function () {

                    })
                    Sections_editor.on('open', function () {
                        console.log('on ouvre le formulaire')
                        console.log('on veut deplacer  le formulaire 2')
                        $('.DTE_Form_Buttons .btn:eq(0)').addClass('btn-primary');
                        $('.DTE_Form_Buttons .btn:eq(1)').addClass('btn-danger');

                        @if($sections_disposition->disposition=="Component")


                        @else
                        $('#Sections_{{$__internalId__}}_parents').hide()

                        @endif

                    })
                    Sections_editor.on('initSubmit', function (editor) {

                    })
                    Sections_editor.on('submitSuccess', function () {
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
                    Sections_editor.on('close', function () {
                        @if($sections_disposition->disposition=="Component")


                        @else
                        $('#Sections_{{$__internalId__}}_parents').show()

                        @endif



                    })

                    return Sections_editor

                }


                let Sections_table = $('#Sections_{{$__internalId__}}').DataTable({


                    ajax: {
                        url: " {{ URL::signedRoute('Sections_web_index_data2',
            [
                'key'=> 'page_id','val'=>$Pages->id]) }}",
                        type: 'POST',
                        cache: true

                    }
                    ,


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
                    buttons: [


                        {
                            extend: 'create',
                            text: "Nouveau",
                            action: function (e, dt, node, config) {
                                that.etat = 'Create'

                            }
                        },


                    ],
                    columns: [

                        {
                            data: null, render: function (data, type, row) {
                                let rendered = ""

                                if (sectionsrender.indexOf('id') != -1) {

                                    let template = Handlebars.compile(sectionsrender['id']);
                                    rendered = template({data: data, all: row});


                                }
                                return rendered;
                            }
                        },


                        {
                            data: 'name', render: function (data, type, row) {
                                let rendered = data
                                if (sectionsrender.indexOf('name') != -1) {
                                    let template = Handlebars.compile(sectionsrender['name']);
                                    rendered = template({data: data, all: row});


                                }
                                return rendered;
                            }
                        },


                        {
                            data: 'ComponentIdRender', render: function (data, type, row) {
                                let rendered = data
                                if (sectionsrender.indexOf('ComponentIdRender') != -1) {
                                    let template = Handlebars.compile(sectionsrender['ComponentIdRender']);
                                    rendered = template({data: data, all: row});


                                }
                                return rendered;
                            }
                        },


                        {
                            data: 'PageIdRender', render: function (data, type, row) {
                                let rendered = data
                                if (sectionsrender.indexOf('PageIdRender') != -1) {
                                    let template = Handlebars.compile(sectionsrender['PageIdRender']);
                                    rendered = template({data: data, all: row});


                                }
                                return rendered;
                            }
                        },


                        {
                            data: 'CreateursRender', render: function (data, type, row) {
                                let rendered = data
                                if (sectionsrender.indexOf('CreateursRender') != -1) {
                                    let template = Handlebars.compile(sectionsrender['CreateursRender']);
                                    rendered = template({data: data, all: row});


                                }
                                return rendered;
                            }
                        },


                        {
                            data: 'CardRender', render: function (data, type, row) {
                                let rendered = data

                                if ('CardRender' in sectionsrender) {
                                    let template = Handlebars.compile(sectionsrender['CardRender']);
                                    rendered = template({data: data, all: row});


                                }
                                return rendered;
                            }
                        },
                        {
                            data: 'CardRenderComponent', render: function (data, type, row) {
                                let rendered = data

                                if ('CardRenderComponent' in sectionsrender) {
                                    let template = Handlebars.compile(sectionsrender['CardRenderComponent']);
                                    rendered = template({data: data, all: row});


                                }
                                return rendered;
                            }
                        },
                        {
                            data: 'CardRenderSelect', render: function (data, type, row) {
                                let rendered = data

                                if ('CardRenderSelect' in sectionsrender) {
                                    let template = Handlebars.compile(sectionsrender['CardRenderSelect']);
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

                                <button style="${!data.CanEditPerms ? 'display:none' : null}" class='btn text-info row-edit p-0 text-center' data-url="${data.SignedEditUrl}"><i class='fas fa-edit'></i></button>

                                <button  style="${!data.CanDeletePerms ? 'display:none' : null}" class='btn btn-danger  row-delete text-center' data-url="${data.SignedDeleteUrl}"><i class='fas fa-trash'></i></button>
                    @endif
                                `;
                            }
                        },

                    ],
                });
                Sections_table.on('processing', function (e, settings, processing) {
                    if (processing) {
                        // $('body').addClass('processingBody')
                        $(`#loader_sections_{{$__internalId__}}`).css('display', 'flex')

                    } else {
                        $(`#loader_sections_{{$__internalId__}}`).css('display', 'none')

                        // $('body').removeClass('processingBody')

                    }
                })
                if ($('#Sections_{{$__internalId__}}_rechercheDatatables').val()) {
                    Sections_table.search($('#Sections_{{$__internalId__}}_rechercheDatatables').val()).draw();

                }
                let Timer_Sections;
                $('#Sections_{{$__internalId__}}_rechercheDatatables').keydown(function () {
                    clearTimeout(Timer_Sections)
                    Timer_Sections = setTimeout(function () {
                        console.log('je demarre la recherche', $('#Sections_{{$__internalId__}}_rechercheDatatables').val())
                        Sections_table.search($('#Sections_{{$__internalId__}}_rechercheDatatables').val()).draw();
                    }, 3000);

                })

                function prefixCss(prefix, cssString) {

                    let doc = document.implementation.createHTMLDocument("")
                    let styleElement = document.createElement("style")
                    styleElement.textContent = cssString;
                    // the style will only be parsed once it is added to a document
                    doc.body.appendChild(styleElement)

                    let styles = [...doc.styleSheets]
                    let allInlineCss = [];
                    styles.forEach(data => {
                        let cssRules = [...data.cssRules]
                        cssRules.forEach(don => {
                            allInlineCss.push(don.cssText)
                        })
                    })
                    allInlineCss = allInlineCss.map(data => {
                        return `#${prefix} ` + data
                    })
                    let allInlineCssRender = allInlineCss.join(' \n')

                    return allInlineCssRender
                }

                Sections_table.on('draw', function () {
                    console.log('on draw')
                    var body = $(Sections_table.table().body());
                    window.livewire.rescan()
                    var column = Sections_table.columns();
                    var column = column[0];

                    let elements = [...Sections_table.data().toArray()]
                    $('#rendu').empty()
                    elements.forEach(data => {
                        $.ajax({
                            url: data.parentUrl,
                        }).done(function (donnes) {
                            let newId = "Text_" + "" + Date.now()                            // console.log('data', data)
                            let newData1 = {}
                            let script = donnes.replace('export default', `newData1=`)
                            eval(script)

                            let element = $('<div>').attr('id', 'sections_' + data.id)
                            $('#rendu').append(element)


                            newData1.name = 'sections_' + data.id
                            let newCss = prefixCss(newData1.name, newData1.style)
                            newData1.template = `<div id="${newData1.name}"> ${newData1.template}</div>`
                            if (!$(`style[data-src-id=${newData1.name}]`).length) {
                                let cssRender = $("<style>")
                                    .attr('data-src-id', newData1.name)
                                    .prop("type", "text/css")
                                $('head').append(cssRender)
                            }
                            $(`style[data-src-id=${newData1.name}]`).text(newCss)
                            newData1.el = '#' + 'sections_' + data.id

                            // newData1.data.customs=data

                            window[`section-${data.id}`] = new Vue(newData1)
                            // window[`section-${data.id}`].customs=Object.assign({},window[`section-${data.id}`].customs, data)


                        })

                    })

                    // console.log(hideColumns)
                    column.forEach(function (data) {
                        let singleton = Sections_table.column(data)

                        if (hideColumnssections.indexOf(singleton.header().textContent.toLowerCase()) != -1) {
                            singleton.visible(false)
                        }

                    })


                    column.forEach(function (data) {
                        let singleton = Sections_table.column(data)
                        if (singleton.header().textContent.toLowerCase() != "CardRenderComponent".toLowerCase()) {
                            singleton.visible(false)
                        }

                    })


                    body.unhighlight();
                    if (Sections_table.rows({filter: 'applied'}).data().length) {
                        body.highlight(Sections_table.search());
                    }
                });


                // Activate an inline edit on click of a table cell
                $('#Sections_{{$__internalId__}}').on('click', '.row-edit', function (e) {
                    let _body_element = $(Sections_table.table().body())
                    _body_element.find('.form_element_child').empty()
                    _body_element.nextAll().empty()
                    _body_element.nextAll().remove()
                    let parent = $($(this).parents("tr"))
                    let tr;
                    if (parent.hasClass('child')) {

                        tr = parent.prev()
                    } else {
                        tr = parent
                    }

                    let data = Sections_table.row(tr).data()

                    // debut de linitiatialisation de lediteur

                    tr.find('.form_element_child').empty()
                    tr.find('.form_element_child').show()
                    tr.find('.form_element_next').hide()


                    function prefixCss(prefix, cssString) {

                        let doc = document.implementation.createHTMLDocument("")
                        let styleElement = document.createElement("style")
                        styleElement.textContent = cssString;
                        // the style will only be parsed once it is added to a document
                        doc.body.appendChild(styleElement)

                        let styles = [...doc.styleSheets]
                        let allInlineCss = [];
                        styles.forEach(data => {
                            let cssRules = [...data.cssRules]
                            cssRules.forEach(don => {
                                allInlineCss.push(don.cssText)
                            })
                        })
                        allInlineCss = allInlineCss.map(data => {
                            return `#${prefix} ` + data
                        })
                        let allInlineCssRender = allInlineCss.join(' \n')

                        return allInlineCssRender
                    }

                    function prefixScript(scripString) {

                        let doc = document.implementation.createHTMLDocument("")
                        let scriptElement = document.createElement("script")
                        // the script will only be parsed once it is added to a document
                        doc.body.innerHTML = ""
                        doc.body.appendChild(scriptElement)
                        console.log('voici le document', doc.scripts[0].textContent)


                    }

                    console.log('voici lelement', data)
                    $.ajax({
                        url: data.parentUrl,
                    })
                        .done(function (donnes) {


                            let newId = "Text_" + "" + Date.now()


                            // console.log('data', data)
                            let newData1 = {}
                            let script = donnes.replace('export default', `newData1=`)


                            eval(script)


                            newData1.name = 'composant-' + data.id
                            let newCss = prefixCss(newData1.name, newData1.style)
                            newData1.template = `<div id="${newData1.name}"> ${newData1.template}</div>`
                            if (!$(`style[data-src-id=${newData1.name}]`).length) {
                                let cssRender = $("<style>")
                                    .attr('data-src-id', newData1.name)
                                    .prop("type", "text/css")
                                $('head').append(cssRender)
                            }
                            $(`style[data-src-id=${newData1.name}]`).text(newCss)
                            let extra_champs = []
                            if (newData1.champs) {
                                extra_champs = newData1.champs
                            }

                            console.log('voici la structures fileds', newData1.champs)


                            let Sections_customForm_id = 'Sections' + Date.now()
                            {{--let Sections_customFormElement = $('#Sections_{{$__internalId__}}_customForm').clone().attr('id', Sections_customForm_id)--}}
                            let Sections_customFormElement = $(`<div>


<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="display:flex;justify-content:space-around">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="pills-element-tab" data-bs-toggle="pill" data-bs-target="#pills-element" type="button" role="tab" aria-controls="pills-element" aria-selected="true">Elements</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-style-tab" data-bs-toggle="pill" data-bs-target="#pills-style" type="button" role="tab" aria-controls="pills-style" aria-selected="false">Styles</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-advance-tab" data-bs-toggle="pill" data-bs-target="#pills-advance" type="button" role="tab" aria-controls="pills-advance" aria-selected="false">Advanced</button>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class=" tab-pane fade show active" id="pills-element" role="tabpanel" aria-labelledby="pills-element-tab">
<div class="row" style="width: 90%;margin: auto;">

</div>
</div>
  <div class="row tab-pane fade" id="pills-style" role="tabpanel" aria-labelledby="pills-style-tab">
<div class="row" style="width: 90%;margin: auto;">

</div>
</div>
  <div class="row tab-pane fade" id="pills-advance" role="tabpanel" aria-labelledby="pills-advance-tab">
<div class="row" style="width: 90%;margin: auto;">

</div>
</div>
</div>
</div>`).attr('id', Sections_customForm_id)

                            $('#form_sections_{{$__internalId__}}').empty()
                            $('#form_sections_{{$__internalId__}}').append(Sections_customFormElement)

                            let allChamps = [


                                {


                                    label: " {{!empty($sections_editorLabels['name'])?$sections_editorLabels['name']:'Name'}}  :",
                                    name: "name"
                                    @if(request()->has('__key__name'))
                                    ,
                                    def: "{{request()->get('__key__name')}}"
                                    @endif
                                },
                                ...extra_champs,


                                {


                                    label: " {{!empty($sections_editorLabels['css'])?$sections_editorLabels['css']:'Css'}}  :",
                                    name: "css",
                                    position: "style",
                                    type: "repeat",
                                    class: 'col-sm-12 order-99',
                                    champs: [
                                        {
                                            label: "Attribut:", name: "attribut", type: 'selectperso',
                                            options: [
                                                {'label': 'MARGIN', 'value': 'margin'},
                                                {'label': 'COLOR', 'value': 'color'},
                                                {'label': 'BACKGROUND IMAGE', 'value': 'background-image'}
                                            ]
                                        },
                                        {label: " Text :", name: "text"},
                                        {label: " color :", name: "color", type: "color"},
                                        {label: " Images :", name: "images", type: "images"},

                                    ],
                                    render: function (data) {
                                        return data.attribut
                                    },
                                    after: function (editor, datatable) {
                                        editor.dependent('attribut', function (val) {
                                            let retour = {}
                                            console.log('voici le changement', val)

                                            if (val && val == 'margin') {
                                                retour['show'] = ['attribut', 'text']
                                                retour['hide'] = ['color', 'images']


                                            } else if (val && val == 'color') {
                                                retour['show'] = ['attribut', 'color']
                                                retour['hide'] = ['text', 'images']


                                            } else if (val && val == 'background-image') {
                                                retour['show'] = ['attribut', 'images']
                                                retour['hide'] = ['text', 'color']


                                            } else {
                                                retour['show'] = ['text']
                                                retour['hide'] = ['color', 'images']
                                            }
                                            return retour
                                        })
                                    }
                                    @if(request()->has('__key__css'))
                                    ,
                                    def: "{{request()->get('__key__css')}}"
                                    @endif
                                },


                                {


                                    label: " {{!empty($sections_editorLabels['media_query'])?$sections_editorLabels['media_query']:'Media_query'}}  :",
                                    name: "media_query",
                                    type: "repeat",
                                    position: "style",
                                    class: 'col-sm-12 order-99',
                                    champs: [
                                        {label: "Min:", name: "min", class: 'col-sm-6 order-01'},
                                        {label: "Max:", name: "max", class: 'col-sm-6 order-01'},
                                        {
                                            label: "Css  :",
                                            name: "css",
                                            type: "repeat",

                                            champs: [
                                                {
                                                    label: "Attribut:", name: "attribut", type: 'selectperso',
                                                    options: [
                                                        {'label': 'MARGIN', 'value': 'margin'},
                                                        {'label': 'COLOR', 'value': 'color'},
                                                        {'label': 'BACKGROUND IMAGE', 'value': 'background-image'}
                                                    ]
                                                },
                                                {label: " Text :", name: "text"},
                                                {label: " color :", name: "color", type: "color"},
                                                {label: " Images :", name: "images", type: "images"},

                                            ],
                                            render: function (data) {
                                                return data.attribut
                                            },
                                            after: function (editor, datatable) {
                                                editor.dependent('attribut', function (val) {
                                                    let retour = {}
                                                    console.log('voici le changement', val)

                                                    if (val && val == 'margin') {
                                                        retour['show'] = ['attribut', 'text']
                                                        retour['hide'] = ['color', 'images']


                                                    } else if (val && val == 'color') {
                                                        retour['show'] = ['attribut', 'color']
                                                        retour['hide'] = ['text', 'images']


                                                    } else if (val && val == 'background-image') {
                                                        retour['show'] = ['attribut', 'images']
                                                        retour['hide'] = ['text', 'color']


                                                    } else {
                                                        retour['show'] = ['text']
                                                        retour['hide'] = ['color', 'images']
                                                    }
                                                    return retour
                                                })
                                            }

                                        },


                                    ],
                                    render: function (data) {
                                        if (data.css.length > 1) {
                                            return `${data.min}  de  ${data.max} ( ${data.css.length} regles ) `

                                        } else {
                                            return `${data.min}  de  ${data.max} ( ${data.css.length} regle ) `

                                        }
                                    },
                                },


                            ]

                            let Sections_editor_config = {

                                ajax: {
                                    create: {
                                        type: 'POST',
                                        url: "{{ URL::signedRoute('Sections_web_create') }}"
                                    },
                                    edit: {
                                        type: 'POST',
                                        url: "{{route('Sections_web_index')}}/_id_/update",
                                    },

                                    remove: {
                                        type: 'POST',
                                        url: "{{route('Sections_web_index')}}/_id_/delete"
                                    },
                                    cache: true

                                },


                                table: '#Sections_{{$__internalId__}}',


                                template: '#' + Sections_customForm_id,
                                display: Sections_onPageDisplay(tr.find('.form_element_child')),
                                fields: allChamps,
                            }
                            allChamps.forEach(data => {
                                if (data.position) {
                                    if (data.position == "style") {
                                        let ele = $(`<div class='${data.class ?? 'col-sm-12'}' data-editor-template='${data.name}'></div>`)
                                        Sections_customFormElement.find('#pills-style').find('.row').append(ele)
                                    }
                                    if (data.position == "advanced") {
                                        let ele = $(`<div class='${data.class ?? 'col-sm-12'}' data-editor-template='${data.name}'></div>`)
                                        Sections_customFormElement.find('#pills-advanced').find('.row').append(ele)
                                    }

                                } else {
                                    let ele = $(`<div class='${data.class ?? 'col-sm-12'}' data-editor-template='${data.name}'></div>`)
                                    Sections_customFormElement.find('#pills-element').find('.row').append(ele)
                                }
                            })


                            $('#form_sections_{{$__internalId__}}')
                            let Sections_editor = new $.fn.dataTable.Editor(Sections_editor_config);


                            Sections_editor.on('preOpen', function () {
                                @if($sections_disposition->disposition=="Component")


                                @else
                                $('#form_sections_{{$__internalId__}}').addClass('card')
                                $('#Sections_{{$__internalId__}}_app_vue').hide()

                                @endif


                            })
                            Sections_editor.on('close', function () {

                                @if($sections_disposition->disposition=="Component")


                                @else
                                $('#form_sections_{{$__internalId__}}').removeClass('card')
                                $('#Sections_{{$__internalId__}}_app_vue').show()

                                @endif




                            })
                            Sections_editor.on('processing', function (e, processing) {
                                // if (processing) {
                                //     $('body').addClass('processingBody')
                                //
                                // } else {
                                //     $('body').removeClass('processingBody')
                                //
                                // }
                            })

                            Sections_editor.on('preOpen', function () {

                            })
                            Sections_editor.on('open', function () {
                                console.log('on ouvre le formulaire')
                                console.log('on veut deplacer  le formulaire 2')
                                $('.DTE_Form_Buttons .btn:eq(0)').addClass('btn-primary');
                                $('.DTE_Form_Buttons .btn:eq(1)').addClass('btn-danger');

                                @if($sections_disposition->disposition=="Component")


                                @else
                                $('#Sections_{{$__internalId__}}_parents').hide()

                                @endif

                            })
                            Sections_editor.on('initSubmit', function (editor) {

                            })
                            Sections_editor.on('submitSuccess', function () {
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
                            Sections_editor.on('close', function () {
                                @if($sections_disposition->disposition=="Component")


                                @else
                                $('#Sections_{{$__internalId__}}_parents').show()

                                @endif



                            })
                            Sections_editor.edit(tr, {
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

                        })


                    //
                    // console.log('voici lobjet de configuration',newData1)
                    //
                    //
                    //
                    // $("#appElement").empty()
                    //
                    // let element= new Vue({el:'#appElement',...newData1})
                    // window.ele=element
                    // let i=16
                    // let structures=newData1.champs
                    // structures=structures.map(dat=>{
                    //
                    //     dat.class="col-sm-12 order-"+i
                    //     i++
                    //     return dat
                    // })
                    // console.log('voici les champs',Sections_editor.order())
                    //
                    // let champsSuppimer=Sections_editor.order().filter(data=>{
                    //     let base=[
                    //         'id',
                    //         'statut',
                    //         'page_id',
                    //         'component_id',
                    //         'name',
                    //         'width',
                    //         'css',
                    //         'media_query',
                    //         '__ID__',
                    //         'dataComponents',
                    //     ]
                    //     return base.indexOf(data)==-1
                    // })
                    // Sections_editor.clear(champsSuppimer)
                    // champsSuppimer.forEach(data=>{
                    //     let oldTemplate=Sections_editor.template()
                    //     oldTemplate.find('.card-body').find('.row').find(`[data-editor-template="${data}"]`).remove()
                    //
                    // })
                    // console.log('voici les champs',Sections_editor.order())
                    //
                    // let newId="Text_"+ "" + Date.now()
                    // let form = $(`<div id='form_${newId}' style="display:none"></div>`)
                    // structures.forEach(data=>{
                    //     let oldTemplate=Sections_editor.template()
                    //     let classe='col-sm-12 order-99'
                    //     if(data.class){
                    //         classe=data.class
                    //
                    //     }
                    //     let el=$(` <div class='${classe}' data-editor-template='${data.name}'></div>`)
                    //     oldTemplate.find('.card-body').find('.row').find('[data-editor-template="css"]').before(el)
                    // })
                    // Sections_editor.add(structures)
                    // console.log( "voici les donnees:", structures );


                });

                // Delete row
                $('#Sections_{{$__internalId__}}').on('click', '.row-delete', function (e) {
                    let _body_element = $(Sections_table.table().body())
                    _body_element.find('.form_element_child').empty()
                    _body_element.nextAll().empty()
                    _body_element.nextAll().remove()
                    let parent = $($(this).parents("tr"))
                    let tr;
                    if (parent.hasClass('child')) {

                        tr = parent.prev()
                    } else {
                        tr = parent
                    }

                    @if($sections_disposition->disposition=="Component")
                    tr.find('.form_element_child').empty()
                    tr.find('.form_element_child').show()
                    tr.find('.form_element_next').hide()

                    let Sections_editor = Sections_getEditor(tr.find('.form_element_child'))
                    @else
                    let Sections_editor = Sections_getEditor($('#form_sections_{{$__internalId__}}'))


                    @endif

                    Sections_editor.remove(tr, {
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
                $('#Sections_{{$__internalId__}}').on('click', '.row-switch', function (e) {

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
                $('#Sections_{{$__internalId__}}').on('click', '.row-child', function (e) {
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


                function SectionsNew(elem) {
                    let Sections_editor = Sections_getEditor(elem)


                    Sections_editor.create().buttons([
                        'Creer',
                        {
                            text: 'Annuler', action: function () {
                                this.close();
                            }
                        }
                    ]).open();
                }


                $('#new_sections_{{$__internalId__}}').on('click', function (e) {
                    SectionsNew($('#form_sections_{{$__internalId__}}'))

                });
                $('.buttons-create').addClass('btn btn-primary');
                $('.buttons-edit').addClass('btn btn-warning');
                $('.buttons-remove').addClass('btn btn-danger');

                let Components_table = $('#Components_{{$__internalId__}}').DataTable({

                    ajax: {
                        url: "{{ route('Components_web_index')}}_data",
                        type: 'POST',
                        cache: true

                    },

                    createRow: function (row, ev) {
                        console.log('row', row, ev)
                    },

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
                    buttons: [],
                    columns: [

                        {data: 'CardRenderSelect'},


                    ],
                    processing: true,
                    serverSide: true
                });
                Components_table.on('processing', function (e, settings, processing) {
                    if (processing) {
                        // $('body').addClass('processingBody')
                        $(`#loader_components_{{$__internalId__}}`).css('display', 'flex')

                    } else {
                        $(`#loader_components_{{$__internalId__}}`).css('display', 'none')

                        // $('body').removeClass('processingBody')

                    }
                })
                if ($('#Components_{{$__internalId__}}_rechercheDatatables').val()) {
                    Components_table.search($('#Components_{{$__internalId__}}_rechercheDatatables').val()).draw();

                }
                let Timer_Components;
                $('#Components_{{$__internalId__}}_rechercheDatatables').keydown(function () {
                    clearTimeout(Timer_Components)
                    Timer_Components = setTimeout(function () {
                        console.log('je demarre la recherche', $('#Components_{{$__internalId__}}_rechercheDatatables').val())
                        Components_table.search($('#Components_{{$__internalId__}}_rechercheDatatables').val()).draw();
                    }, 3000);

                })


                Components_table.on('draw', function () {
                    console.log('on draw')
                    var body = $(Components_table.table().body());
                    window.livewire.rescan()
                    var column = Components_table.columns();
                    var column = column[0];


                    body.unhighlight();
                    if (Components_table.rows({filter: 'applied'}).data().length) {
                        body.highlight(Components_table.search());
                    }


                });


                // Activate an inline edit on click of a table cell
                $('#Components_{{$__internalId__}}').on('click', '.row-edit', function (e) {
                    let _body_element = $(Components_table.table().body())
                    _body_element.find('.form_element_child').empty()
                    _body_element.nextAll().empty()
                    _body_element.nextAll().remove()
                    let parent = $($(this).parents("tr"))
                    let tr;
                    if (parent.hasClass('child')) {

                        tr = parent.prev()
                    } else {
                        tr = parent
                    }


                    // debut de linitiatialisation de lediteur


                    Components_editor.field('createurs').hide()


                    Components_editor.edit(tr, {
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

                $('#Components_{{$__internalId__}}').on('click', 'tr', function (e) {


                    Sections_customForm_id = 'Sections' + Date.now()
                    let Sections_customFormElement = $('#Sections_{{$__internalId__}}_customForm').clone().attr('id', Sections_customForm_id)

                    $('#form_sections_{{$__internalId__}}').empty()
                    $('#form_sections_{{$__internalId__}}').append(Sections_customFormElement)


                    let Sections_editor_config = {

                        ajax: {
                            create: {
                                type: 'POST',
                                url: "{{ URL::signedRoute('Sections_web_create') }}"
                            },
                            edit: {
                                type: 'POST',
                                url: "{{route('Sections_web_index')}}/_id_/update",
                            },

                            remove: {
                                type: 'POST',
                                url: "{{route('Sections_web_index')}}/_id_/delete"
                            },
                            cache: true

                        },


                        table: '#Sections_{{$__internalId__}}',


                        template: '#' + Sections_customForm_id,
                        fields: [


                            {
                                label: " {{!empty($sections_editorLabels['id'])?$sections_editorLabels['id']:'Id'}}  :",
                                name: "id",
                                submit: 'false'
                            },
                            {
                                label: " {{!empty($sections_editorLabels['id'])?$sections_editorLabels['id']:'Id'}}  :",
                                name: "parentUrl"
                            },


                            {


                                label: " {{!empty($sections_editorLabels['name'])?$sections_editorLabels['name']:'Name'}}  :",
                                name: "name"
                                @if(request()->has('__key__name'))
                                ,
                                def: "{{request()->get('__key__name')}}"
                                @endif
                            },


                            {


                                label: " {{!empty($sections_editorLabels['css'])?$sections_editorLabels['css']:'Css'}}  :",
                                name: "css",
                                type: "repeat",
                                class: 'col-sm-12 order-99',
                                champs: [
                                    {
                                        label: "Attribut:", name: "attribut", type: 'selectperso',
                                        options: [
                                            {'label': 'MARGIN', 'value': 'margin'},
                                            {'label': 'COLOR', 'value': 'color'},
                                            {'label': 'BACKGROUND IMAGE', 'value': 'background-image'}
                                        ]
                                    },
                                    {label: " Text :", name: "text"},
                                    {label: " color :", name: "color", type: "color"},
                                    {label: " Images :", name: "images", type: "images"},

                                ],
                                render: function (data) {
                                    return data.attribut
                                },
                                after: function (editor, datatable) {
                                    editor.dependent('attribut', function (val) {
                                        let retour = {}
                                        console.log('voici le changement', val)

                                        if (val && val == 'margin') {
                                            retour['show'] = ['attribut', 'text']
                                            retour['hide'] = ['color', 'images']


                                        } else if (val && val == 'color') {
                                            retour['show'] = ['attribut', 'color']
                                            retour['hide'] = ['text', 'images']


                                        } else if (val && val == 'background-image') {
                                            retour['show'] = ['attribut', 'images']
                                            retour['hide'] = ['text', 'color']


                                        } else {
                                            retour['show'] = ['text']
                                            retour['hide'] = ['color', 'images']
                                        }
                                        return retour
                                    })
                                }
                                @if(request()->has('__key__css'))
                                ,
                                def: "{{request()->get('__key__css')}}"
                                @endif
                            },


                            {


                                label: " {{!empty($sections_editorLabels['media_query'])?$sections_editorLabels['media_query']:'Media_query'}}  :",
                                name: "media_query",
                                type: "repeat",
                                class: 'col-sm-12 order-99',
                                champs: [
                                    {label: "Min:", name: "min", class: 'col-sm-6 order-01'},
                                    {label: "Max:", name: "max", class: 'col-sm-6 order-01'},
                                    {
                                        label: "Css  :",
                                        name: "css",
                                        type: "repeat",

                                        champs: [
                                            {
                                                label: "Attribut:", name: "attribut", type: 'selectperso',
                                                options: [
                                                    {'label': 'MARGIN', 'value': 'margin'},
                                                    {'label': 'COLOR', 'value': 'color'},
                                                    {'label': 'BACKGROUND IMAGE', 'value': 'background-image'}
                                                ]
                                            },
                                            {label: " Text :", name: "text"},
                                            {label: " color :", name: "color", type: "color"},
                                            {label: " Images :", name: "images", type: "images"},

                                        ],
                                        render: function (data) {
                                            return data.attribut
                                        },
                                        after: function (editor, datatable) {
                                            editor.dependent('attribut', function (val) {
                                                let retour = {}
                                                console.log('voici le changement', val)

                                                if (val && val == 'margin') {
                                                    retour['show'] = ['attribut', 'text']
                                                    retour['hide'] = ['color', 'images']


                                                } else if (val && val == 'color') {
                                                    retour['show'] = ['attribut', 'color']
                                                    retour['hide'] = ['text', 'images']


                                                } else if (val && val == 'background-image') {
                                                    retour['show'] = ['attribut', 'images']
                                                    retour['hide'] = ['text', 'color']


                                                } else {
                                                    retour['show'] = ['text']
                                                    retour['hide'] = ['color', 'images']
                                                }
                                                return retour
                                            })
                                        }

                                    },


                                ],
                                render: function (data) {
                                    if (data.css.length > 1) {
                                        return `${data.min}  de  ${data.max} ( ${data.css.length} regles ) `

                                    } else {
                                        return `${data.min}  de  ${data.max} ( ${data.css.length} regle ) `

                                    }
                                },
                                @if(request()->has('__key__media_query'))def: "{{request()->get('__key__media_query')}}"
                                @endif
                            },


                            {


                                label: " {{!empty($sections_editorLabels['statut'])?$sections_editorLabels['statut']:'Statut'}}  :",
                                name: "statut",
                                def: '0',
                            },


                            {
                                label: " {{!empty($sections_editorLabels['extra_attributes'])?$sections_editorLabels['extra_attributes']:'Extra_attributes'}}  :",
                                name: "extra_attributes",
                                submit: 'false'
                            },


                            {
                                label: " {{!empty($sections_editorLabels['deleted_at'])?$sections_editorLabels['deleted_at']:'Deleted_at'}}  :",
                                name: "deleted_at",
                                submit: 'false'
                            },


                            {
                                label: " {{!empty($sections_editorLabels['created_at'])?$sections_editorLabels['created_at']:'Created_at'}}  :",
                                name: "created_at",
                                submit: 'false'
                            },


                            {
                                label: " {{!empty($sections_editorLabels['updated_at'])?$sections_editorLabels['updated_at']:'Updated_at'}}  :",
                                name: "updated_at",
                                submit: 'false'
                            },


                            {


                                label: " {{!empty($sections_editorLabels['createurs'])?$sections_editorLabels['createurs']:'Createurs'}}  :",
                                name: "createurs",
                                type: "select1",
                                entite: 'users'
                                @if(request()->has('__key__createurs'))
                                ,
                                def: "{{request()->get('__key__createurs')}}"
                                @endif

                            },


                            // les parents1
                            // les parents component
                                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="component_id"   )


                            {


                                label: "Components:",
                                name: "component_id",
                                def: "{{request()->get('pval')}}",
                                type: "hidden"
                            },
                                @else
                            {
                                label: "Components:", name: "component_id", type: "select1", entite: 'components'
                            },

                            @endif
                            // les parents page


                            {


                                label: "Pages:",
                                name: "page_id",
                                def: "{{$Pages->id}}",
                                type: "hidden"
                            },


                        ],
                    }

                    let Sections_editor = new $.fn.dataTable.Editor(Sections_editor_config);
                    let tr = $(this)
                    let data = Components_table.row(tr).data()
                    that.etat = 'Listes'
                    console.log('on as cliquer sur un element', data, Sections_editor)
                    Sections_editor
                        .create()
                        .set('component_id', [data.id])
                        .set('page_id', [{{$Pages->id}}])
                        .set('name', 'section ' + Sections_table.data().length)
                        .set('parentUrl', data.structures)
                        .submit()
                    // alert('on as cliquer sur un truck')

                });


                function ComponentsNew(elem) {
                    let Components_editor = Components_getEditor(elem)


                    Components_editor.field('createurs').show()


                    Components_editor.create().buttons([
                        'Creer',
                        {
                            text: 'Annuler', action: function () {
                                this.close();
                            }
                        }
                    ]).open();
                }


                $('#new_components_{{$__internalId__}}').on('click', function (e) {
                    ComponentsNew($('#form_components_{{$__internalId__}}'))

                });
                $('.buttons-create').addClass('btn btn-primary');
                $('.buttons-edit').addClass('btn btn-warning');
                $('.buttons-remove').addClass('btn btn-danger');
            }
        })
    </script>






























    <script>
        $('.tab-content').append($('.tab-extra'))
    </script>

@endsection
