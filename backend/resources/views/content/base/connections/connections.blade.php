{{--@extends('layouts/contentLayoutMaster')--}}
{{--@section('vendor-style')--}}
{{--    <!-- vendor css files -->--}}
{{--    --}}{{-- vendor css files --}}
{{--    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">--}}
{{--    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">--}}
{{--    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">--}}
{{--    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">--}}
{{--    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">--}}
{{--@endsection--}}
{{--@section('page-style')--}}
{{--    <link href="{{mix('css/personnal/editor/editor_beau_formulaire.css')}}" rel="stylesheet" type="text/css">--}}
{{--    <link href="{{mix('css/personnal/admin/admin.css')}}" rel="stylesheet" type="text/css">--}}
{{--    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">--}}
{{--    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">--}}
{{--    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/tables/datatables.searchHighLight.css')) }}">--}}
{{--    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/tables/select.datatables.css')) }}">--}}


{{--@endsection--}}

{{--@section('title','connections')--}}
{{--@section('content')--}}
{{--    <div class="container">--}}


{{--        <div class="ui-block mb-3">--}}
{{--            <div class="ui-block-title bg-primary">--}}
{{--                <h5 class="title text-light titre">--}}
{{--                    <svg class='olymp-month-calendar-icon left-menu-icon'data-bs-toggle='tooltip' data-bs-placement='right'> <use xlink:href='#olymp-month-calendar-icon'></use></svg>--}}
{{--                    Les connections--}}
{{--                    <i id="new" class="fa fa-plus text-light" style="float: right"></i></h5>--}}
{{--            </div>--}}


{{--        </div>--}}

{{--    </div>--}}

{{--    <div id='app'>--}}
{{--        <div id='form'></div>--}}
{{--        <div id='app_vue' v-show='show_table'>--}}
{{--            <div class='tables'>--}}
{{--                <table id='connections' class='display table table-striped' style='width:100%'>--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th></th>--}}
{{--                        <th>id_connections</th>--}}
{{--                        <th>ip</th>--}}
{{--                        <th>email</th>--}}
{{--                        <th>password</th>--}}
{{--                        <th>operations</th>--}}
{{--                        <th>created_at</th>--}}
{{--                        <th>updated_at</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div id='customForm' class='row'>--}}
{{--        <div class='col-md-12' data-editor-template='id_connections'></div>--}}
{{--        <div class='col-md-12' data-editor-template='ip'></div>--}}
{{--        <div class='col-md-12' data-editor-template='email'></div>--}}
{{--        <div class='col-md-12' data-editor-template='password'></div>--}}
{{--        <div class='col-md-12' data-editor-template='operations'></div>--}}
{{--        <div class='col-md-12' data-editor-template='created_at'></div>--}}
{{--        <div class='col-md-12' data-editor-template='updated_at'></div>--}}

{{--    </div>--}}
{{--@endsection--}}
{{--@section('vendor-script')--}}
{{--    <!-- vendor files -->--}}
{{--    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.select.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>--}}

{{--    <script src="{{asset('vendors/js/tables/datatable/dataTables.editor.min.js')}}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/ckeditor/ckeditor.complet.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('js/personnal/editor/editor_personnal_field.js')) }}"></script>--}}
{{--@endsection--}}
{{--@section('page-script')--}}
{{--    <script src="{{ asset(mix('vendors/js/vuejs/vue2.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/jquery/jquery.hightlight.min.js')) }}"></script>--}}
{{--    <script src="{{ asset(mix('vendors/js/tables/datatable/search.hightlight.min.js')) }}"></script>--}}
{{--    <script>
import CustomSelect from "@/components/CustomSelect.vue";--}}
{{--        var app = new Vue({--}}
{{--            el: '#app',--}}
{{--            data: {--}}
{{--                message: 'Hello Vue!',--}}
{{--                show_table: true,--}}
{{--            },--}}
{{--            methods: {},--}}
{{--            mounted() {--}}
{{--                $.ajaxSetup({--}}
{{--                    headers: {--}}
{{--                        'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')--}}
{{--                    }--}}
{{--                });--}}
{{--                let that = this;--}}

{{--                function onPageDisplay(elm) {--}}
{{--                    var name = 'onPage' + Math.random();--}}
{{--                    var Editor = $.fn.dataTable.Editor;--}}
{{--                    var emptyInfo;--}}

{{--                    Editor.display[name] = $.extend(true, {}, Editor.models.display, {--}}
{{--                        // Create the HTML mark-up needed the display controller--}}
{{--                        init: function (editor) {--}}
{{--                            emptyInfo = elm.html();--}}
{{--                            return Editor.display[name];--}}
{{--                        },--}}

{{--                        // Show the form--}}
{{--                        open: function (editor, form, callback) {--}}
{{--                            elm.children().detach();--}}
{{--                            elm.append(form);--}}

{{--                            if (callback) {--}}
{{--                                callback();--}}
{{--                            }--}}
{{--                        },--}}

{{--                        // Hide the form--}}
{{--                        close: function (editor, callback) {--}}
{{--                            elm.children().detach();--}}
{{--                            elm.html(emptyInfo);--}}

{{--                            if (callback) {--}}
{{--                                callback();--}}
{{--                            }--}}
{{--                        }--}}
{{--                    });--}}

{{--                    return name;--}}
{{--                }--}}

{{--                $('#connections').css('width', '100%')--}}
{{--                const params = new URLSearchParams(window.location.search)--}}
{{--                parametre = []--}}

{{--                for (const param of params) {--}}
{{--                    var obj = {};--}}
{{--                    param.forEach((key, value) => {--}}
{{--                        if (value == 0) {--}}
{{--                            obj.label = key--}}
{{--                        } else {--}}
{{--                            obj.value = key--}}
{{--                        }--}}

{{--                    })--}}
{{--                    parametre.push(obj)--}}

{{--                }--}}
{{--                let table = $('#connections').DataTable({--}}
{{--                    ajax: {--}}
{{--                        url: 'Connections',--}}
{{--                        type: 'POST',--}}
{{--                        data: {'request': parametre},--}}
{{--                    },--}}

{{--                    searchHighlight: true,--}}
{{--                    language: {--}}
{{--                        search: 'Chercher:',--}}
{{--                        zeroRecords: 'aucun resultats',--}}
{{--                        sSearchPlaceholder: 'Entrez votre recherche',--}}
{{--                    },--}}
{{--                    fixedHeader: true,--}}
{{--                    columnDefs: [{--}}
{{--                        orderable: false,--}}
{{--                        className: 'select-checkbox',--}}
{{--                        targets: 0--}}
{{--                    }],--}}
{{--                    select: {--}}
{{--                        style: 'os',--}}
{{--                        selector: 'td:first-child'--}}
{{--                    },--}}
{{--                    paging: true,--}}
{{--                    lengthMenu: [[5, 6, 7, 8, 9, 10, 50, 100, -1], [5, 6, 7, 8, 9, 10, 50, 100, 'TOUTES']],--}}
{{--                    colReorder: {--}}
{{--                        realtime: false,--}}
{{--                    },--}}
{{--                    dom: 'lBfrtip',--}}
{{--                    responsive: true,--}}
{{--                    deferRender: true,--}}
{{--                    select: true,--}}
{{--                    buttons: [], columns: [--}}

{{--                        {--}}
{{--                            data: null, render: function (data, type, row) {--}}
{{--                                return ``;--}}
{{--                            }--}}
{{--                        },// la donnee id_connections--}}
{{--                        {data: 'id_connections'},--}}
{{--// la donnee ip--}}
{{--                        {data: 'ip'},--}}
{{--// la donnee email--}}
{{--                        {data: 'email'},--}}
{{--// la donnee password--}}
{{--                        {data: 'password'},--}}
{{--// la donnee operations--}}
{{--                        {data: 'operations'},--}}
{{--// la donnee created_at--}}
{{--                        {data: 'created_at'},--}}
{{--// la donnee updated_at--}}
{{--                        {data: 'updated_at'},--}}

{{--                    ],--}}
{{--                });--}}


{{--                table.on('draw', function () {--}}
{{--                    console.log('on draw')--}}
{{--                    var body = $(table.table().body());--}}

{{--                    body.unhighlight();--}}
{{--                    if (table.rows({filter: 'applied'}).data().length) {--}}
{{--                        body.highlight(table.search());--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}
{{--        })--}}

{{--    </script>--}}
{{--@endsection--}}


@extends('layouts/olympius/base4')
@section('vendor-style')
    <!-- vendor css files -->
    {{-- vendor css files --}}
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
            background: #19589b !important;
            padding: 50px;
        }

        .articles_div img {
            max-width: 100%;
            height: 200px;
            margin: 0 auto;
            display: block;

        }

        .connections_div {
            background: #fff;
            padding: 50px;

        }

        .article {
            margin: 10px auto;

        }

        .content {

        }
    </style>
@endsection

@section('title','login')
@section('content')

    <div id="parent">
        <div class="row rounded">
            <div class="col-sm-6 articles_div">
                <img src="{{asset('images/logo/logob.png')}}" alt="">

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
                        <h3 class="card-title text-primary">Bienvenu sur L'intranet Generateur</h3>
                        <p class="card-text">Connectez vous avec vos identifiant pour acceder a votre espace de
                            travail.</p>
                    </div>
                </div>
            </div>
            <div class='col-md-12' data-editor-template='email'></div>
            <div class='col-md-12' data-editor-template='password'></div>

        </div>
        <div id='customForm2' class='row'>
            <div class="col-md-12 col-lg-12">
                <div class="card text-center mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Bienvenu sur L'intranet Generateur</h4>
                        <p class="card-text">Veuillez vous inscrire si vous navez pas de compte.</p>
                    </div>
                </div>
            </div>
            <div class='col-md-12' data-editor-template='name'></div>
            <div class='col-md-12' data-editor-template='prenoms'></div>
            <div class='col-md-12' data-editor-template='contact'></div>
            <div class='col-md-12' data-editor-template='email'></div>
            <div class='col-md-12' data-editor-template='password'></div>
            <div class='col-md-12' data-editor-template='password1'></div>

        </div>
    </div>

@endsection
@section('vendor-script')
    <!-- vendor files -->
    {{--    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>--}}
    <script src="{{ asset('vendors/js/tables/DataTables-1.11.3/js/jquery.dataTables.min.js') }}"></script>
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
@endsection
@section('page-script')

    <script>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
            }
        });
        let that = this;

        let table = $('#articles').DataTable({
            ajax: {
                url: '{{ route('Articles_web_index')}}_data',
                type: 'GET',
            },

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
            'Se connecter',
            {
                text: "S'enregistrer", action: function () {
                    editor.close()
                    editor2.create().buttons([
                        "S'enregistrer",
                        {
                            text: "Se connecter", action: function () {
                                editor2.close()
                                editor.open()
                            }
                        }
                    ]).open()

                    $('.DTE_Form_Buttons .btn:eq(0)').addClass('btn-primary');
                    // $('.DTE_Form_Buttons .btn:eq(1)').addClass('btn-danger');
                }
            }
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


    </script>
@endsection


