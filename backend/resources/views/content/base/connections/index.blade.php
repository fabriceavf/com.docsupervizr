@php
    use App\Models\prod\ConfigurationsModel;$data1=ConfigurationsModel::where('cle','Page-connections-text')->get()->toArray();
    if(count($data1)>0){
        $data1=$data1[0];
    }else{
        $data1=[];
    }
    $url1=$data1['Filesfiles'][0]??'images/logo/logobl.png';
    $data2=ConfigurationsModel::where('cle','Page-connections-background')->get()->toArray();
    if(count($data2)>0){
        $data2=$data2[0];
    }else{
        $data2=[];
    }

    $url=$data2['Filesfiles'][0]??'images/banner/login-ban.jpeg';



@endphp

dd
<!DOCTYPE html>
<html lang="en">
<head>


    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}"/>
    <link rel="stylesheet" href="{{ asset(mix('css/core_bootsrap.css')) }}"/>
    <link rel="stylesheet" href="{{asset('fontawesome-free/css/all.min.css')}}">
    <link href="{{asset('css/personnal/editor/editor_beau_formulaire.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/personnal/admin/admin.css')}}" rel="stylesheet" type="text/css">
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
    <link rel="stylesheet" href="{{ asset('css/personnal/autocomplete.min.css') }}">

    <style>
        body {
            background-image: url({{asset($url)}}) !important;
        }

        #articles thead {
            display: none;
        }

        #articles tr {
            display: flex;
            flex-direction: column;
            align-items: center;
            display: flex;
            border: #d8d6de 1px solid;
            border-radius: 5px;
            background: #fff;
        }

        #articles tr td {
            background: none !important;
            border-bottom: 0px !important;
        }

        .articles_div {
            border-right: 5px #ffd600 solid !important;
            background: #014691 !important;
            padding: 50px;
        }

        .articles_div img {
            max-width: 100%;
            height: 200px;
            margin: 0 auto;
            display: block;

        }

        .connections_div {
            background-color: #fff !important;
            padding: 30px !important;

        }

        .article {
            margin: 10px auto;

        }

        .content {

        }
    </style>


    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .dropzone_error {

            animation-name: shakeError;
            animation-fill-mode: forwards;
            animation-duration: .6s;
            animation-timing-function: ease-in-out;
        }

    </style>
    <style>
        #dropzone-examples {
            border: 2px solid #9d9292;
        }

        .dropzone .dz-message::before {
            top: 0 !important;
            display: none !important;
        }

        .dropzone {
            min-height: 100px !important;
        }

        .Field_dropzone_table_tbody {
            display: flex;
            gap: 10px;
            flex-flow: wrap;
            justify-content: center;
        }

        .Field_dropzone_table_tbody tr {
            display: flex;
            flex-direction: column;
            width: 200px;
            position: relative;
            border-radius: 5px;
            background: none;
            border: 1px dashed black;
        }

        .Field_dropzone_table_tbody tr td {
            background: #fff !important;
            border: none !important;
        }

        .Field_dropzone_table_tbody tr .old_name, .new_name, .id_files, .descriptions, .extensions, .size, .path, .web_path, .created_at, .updated_at {
            display: none;
        }

        .Field_dropzone_table_tbody tr .supprime_image {
            background: #000 !important;
            color: #fff;
            border-radius: 5px;
            margin: 10px;

        }

        .Field_dropzone_table_tbody tr .render img {
            width: 90%;
            max-height: 200px;

        }
    </style>

    <style>
        .corps {
            margin-bottom: 50px;
        }

        .select2-container {
            position: relative !important;
            top: 0 !important;
            left: 0 !important;
        }

        table img {
            max-width: 200px;
        }

        .rendered ul {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;

        }

        .rendered ul li {
            display: flex;
            gap: 10px;
            flex-direction: column;
            padding: 10px;
            border: 2px dashed #ccc;
            height: 200px;

        }

        .rendered ul li img {
            max-height: 150px;
            height: 100%;

        }

        .rendered ul li button {
            margin-top: 0 !important;
            position: static !important;
            width: 100% !important;
            background: #000;
            color: #fff;
            border-radius: 0;

        }

        div.DTE div.editor_upload div.drop {
            height: 150px !important;
        }
    </style>
    <style>
        .DTE_Body_Content {
            color: black !important;
        }
    </style>
    <style>


        div.DTE_Body div.DTE_Body_Content div.DTE_Field {
            /*border: #403f3f1c solid 5px;*/
            /*padding: 20px 5px !important;*/
            /*margin: 20px auto;*/
            /*border-radius: 5px;*/
            /*background: #fff;*/
            width: 100%;
        }

    </style>
    <style>
        div.dataTables_wrapper div.dataTables_filter label {
            margin: 0 auto !important;
            display: flex !important;
            flex-direction: column !important;
        }

        body {
            background: #8F9396;
            background-image: url('{{asset("images/banner/login-ban.jpeg")}}');
            background-repeat: no-repeat;
            background-size: cover !important;
        }

        .base_div {
            max-width: 100% !important;
            margin: 0px auto;
        }

        .background {
            background: #011529;
            width: 100%;
            height: 100vh;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.7;
            z-index: -1;

        }

        .content {
            background: #fff;
            border-radius: 5px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* .articles_div {
            border-right: 5px #b0a4a4 solid;
            padding: 50px;


        } */

        /* .articles_div img {
            max-width: 100%;
            height: 200px;
            margin: 0 auto;
            display: block;


        } */

        .connections_div {
            background: #38b2ac;
            padding: 50px;
            height: 100%;

        }

        .connections_div .DTE_Label {
            color: #fff;
            font-weight: 500;
        }

        /* .article {
            margin: 10px auto;

        } */

    </style>

</head>
<body class="" style="background-color: #ccc !important">


<div class="container base_div">
    <div class="background"></div>
    <div class="content">


        <div id="parent">
            <div class="row rounded ">
                <div class="col-sm-6 articles_div">
                    <img src="{{asset($url1)}}" class="w-75" alt="">

                    @foreach($articles->slice(0,3) as $article)
                        <div class="card article">
                            {{--                <div class="card-header">Featured</div>--}}
                            <div class="card-body pb-1">
                                <h5 class="card-title text-primary">
                                    <i class="fas fa-newspaper"></i> {{$article->label}}</h5>
                                <p class="card-text">
                                    {{$article->introduction}}
                                </p>
                                {{--                    <a href="javascript:void(0)" class="btn btn-outline-primary">Go somewhere</a>--}}
                            </div>
                        </div>

                    @endforeach
                </div>
                <div class="col-sm-6 connections_div">


                    <div id='form'>

                    </div>
                </div>
            </div>


            <div id='customForm' class='row'>
                <div class="col-md-12 col-lg-12">
                    <div class="card text-center mb-3">
                        <div class="card-body">
                            <h3 class="card-title text-primary">{{$data1['valeur1']??"Bienvenu sur Gtech"}}</h3>
                            <p class="card-text">{{$data1['valeur2']??"Connectez vous avec vos identifiant pour acceder a votre espace de
                            travail."}}</p>
                        </div>
                    </div>
                </div>
                <div class='col-md-12' data-editor-template='email'></div>
                <div class='col-md-12' data-editor-template='password'></div>

            </div>
        </div>


    </div>

</div>


<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/jquery/jquery2.js')) }}"></script>
<script src="{{ asset('vendors/js/tables/DataTables-1.11.3/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.select.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap45.min.js') }}"></script>

<script src="{{asset('vendors/js/tables/datatable/dataTables.editor.min.js')}}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/ckeditor/ckeditor.complet.min.js')) }}"></script>
<script src="{{ asset(mix('js/personnal/editor/editor_personnal_field.js')) }}"></script>

<script src="{{ asset(mix('vendors/js/jquery/jquery.hightlight.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/search.hightlight.min.js')) }}"></script>
<script src="{{ asset('js/personnal/autocomplete.min.js') }}"></script>
<script>
    import CustomSelect from "@/components/CustomSelect.vue";


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
        }
    });
    let that = this;

    let table = $('#articles').DataTable({


        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,


        paging: true,
        lengthMenu: [[5], [5]],
        colReorder: {
            realtime: false,
        },
        dom: 't',
        responsive: true,
        deferRender: true,
        select: true,
        buttons: [],
        columns: [

            // la donnee id  {data: 'id'},
// la donnee label
            {
                data: null, render: function (data, type, row) {
                    return `
                             <div>

                                    <div class="notification-event">
                                                <div><a href="#" class="h6 notification-friend">${data.label}</div>
                                                <divclass="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">${data.created_at}</time></div>
                                    </div>



                            </div>

                             `;
                }
            },


        ],
    });


    function onPageDisplay(elm) {
        var name = 'onPage' + Math.random();
        var Editor = $.fn.dataTable.Editor;
        var emptyInfo;

        Editor.display[name] = $.extend(true, {}, Editor.models.display, {
            // Create the HTML mark-up needed the display controller
            init: function (edito) {
                emptyInfo = elm.html();
                return Editor.display[name];
            },

            // Show the form
            open: function (edito, form, callback) {
                elm.children().detach();
                elm.append(form);

                if (callback) {
                    callback();
                }
            },

            // Hide the form
            close: function (edito, callback) {
                elm.children().detach();
                elm.html(emptyInfo);

                if (callback) {
                    callback();
                }
            }
        });

        return name;
    }

    $('#contenu').css('width', '100%')
    let editor = new $.fn.dataTable.Editor({
        ajax: {
            url: 'connections',
            type: 'POST',
        },
        template: '#customForm',
        display: onPageDisplay($('#form')),
        fields: [
            // le champs id_contenu
            // {label: 'id_contenu :', name: 'id_contenu'},
            // le champs label
            {label: 'Votre Identifiant :', name: 'email'},
            // le champs description
            {label: 'Votre mot de passe:', name: 'password', type: 'password'},


        ],
    });

    let editor2 = new $.fn.dataTable.Editor({
        ajax: {
            url: 'inscriptions',
            type: 'POST',
        },
        template: '#customForm2',
        display: onPageDisplay($('#form')),
        fields: [
            // le champs id_contenu
            // {label: 'id_contenu :', name: 'id_contenu'},
            // le champs label
            {label: 'Votre noms :', name: 'name'},
            {label: 'Votre prenoms :', name: 'prenoms'},
            {label: 'Votre contact :', name: 'contact'},
            {label: 'Votre email :', name: 'email'},
            {label: 'Votre mot de passe :', name: 'password', type: "password"},
            {label: 'Confirmer votre mot de passe :', name: 'password1', type: "password"},

        ],
    });


    editor.create().buttons([
        'Se connecter'
    ]).open()


    $('.buttons-create').addClass('btn btn-primary');
    $('.buttons-edit').addClass('btn btn-warning');
    $('.buttons-remove').addClass('btn btn-danger');
    $('.DTE_Form_Buttons .btn:eq(0)').addClass('btn-primary');
    // $('.DTE_Form_Buttons .btn:eq(1)').addClass('btn-danger');

    editor.on('initSubmit', function (editor) {
        console.log('je mapprete a soumettre les donnees')
    })
    editor.on('submitSuccess', function (e, data) {
        console.log('je recharge les donnees', data)
        $('#parent').hide()
        window.location.replace(`${data.data.url}`);

    })
    editor.on('close', function () {
        console.log('on ferme le formulaire')

    })
    editor2.on('initSubmit', function (editor2) {
        console.log('je mapprete a soumettre les donnees')
    })
    editor2.on('submitSuccess', function (e, data) {
        console.log('je recharge les donnees', data)
        window.location.replace(`${data.data.url}`);

    })
    editor2.on('close', function () {
        console.log('on ferme le formulaire')

    })

    var countries = [
        {label: 'United Kingdom', value: 'UK'},
        {label: 'United States', value: 'US'}
    ];

    var input = document.getElementById("DTE_Field_email");

    autocomplete({
        input: input,
        fetch: function (text, update) {
            text = text.toLowerCase();
            // you can also use AJAX requests instead of preloaded data
            var suggestions = countries.filter(n => n.label.toLowerCase().startsWith(text))
            update(suggestions);
        },
        onSelect: function (item) {
            input.value = item.label;
        }
    });


</script>


</body>
</html>



