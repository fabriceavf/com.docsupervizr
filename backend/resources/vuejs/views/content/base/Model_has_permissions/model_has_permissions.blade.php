@extends('layouts/contentLayoutMaster')
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
@endsection

@section('title','Gestion des permissions des utilisateurs')
@section('content')
    <div class="container">


        <div class="ui-block mb-3">
            <div class="ui-block-title bg-primary">
                <h5 class="title text-light titre">
                    <svg class='olymp-month-calendar-icon left-menu-icon' data-bs-toggle='tooltip'
                         data-bs-placement='right'>
                        <use xlink:href='#olymp-month-calendar-icon'></use>
                    </svg>
                    Les permissions dun users
                    <i id="new" class="fa fa-plus text-light" style="float: right"></i></h5>
            </div>


        </div>

    </div>



    <div class='container editor_enfant_box'>
        {{--        <H2>Ratacher des permissions a des users</H2>--}}
        <div id='app'>
            <div id='form'></div>
            <div id='app_vue' v-show='show_table'>
                <div class='tables'>
                    <table id='model_has_permissions' class='display table table-striped' style='width:100%'>
                        <thead>
                        <tr>
                            <th></th>
                            <th>Noms</th>
                            {{--                        <th>model_type</th>--}}
                            <th>Permissions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div id='customForm' class='row'>
            <div class='col-md-12' data-editor-template='model_id'></div>
            <div class='col-md-12' data-editor-template='permission_id'></div>


        </div>
    </div>
@endsection
@section('vendor-script')
    <!-- vendor files -->

@endsection
@section('page-script')

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                message: 'Hello Vue!',
                show_table: true,
                table: null,
                editor: null
            },
            methods: {},
            mounted() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                    }
                });
                let that = this;

                function onPageDisplay(elm) {
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

                $('#model_has_permissions').css('width', '100%')
                let editor = new $.fn.dataTable.Editor({
                    ajax: {
                        url: 'Model_has_permissions',
                        type: 'POST',
                    },
                    table: '#model_has_permissions',
                    template: '#customForm',
                    display: onPageDisplay($('#form')),
                    fields: [
                        // le champs model_id
                        {label: 'Utilisateur :', name: 'model_id', type: "selectperso"},
                        // le champs permission_id
                        {label: 'Permission :', name: 'permission_id', type: "selectperso"},
                        // le champs model_type
                        // {label: 'model_type :', name: 'model_type',type:"selectperso},

                    ],
                });
                that.editor = editor
                const params = new URLSearchParams(window.location.search)
                parametre = []

                for (const param of params) {
                    var obj = {};
                    param.forEach((key, value) => {
                        if (value == 0) {
                            obj.label = key
                        } else {
                            obj.value = key
                        }

                    })
                    parametre.push(obj)

                }
                let table = $('#model_has_permissions').DataTable({
                    ajax: {
                        url: 'Model_has_permissions',
                        type: 'POST',
                        data: {'request': parametre},
                    },

                    searchHighlight: true,
                    language: {
                        search: 'Chercher:',
                        zeroRecords: 'aucun resultats',
                        sSearchPlaceholder: 'Entrez votre recherche',
                    },
                    fixedHeader: true,
                    columnDefs: [{
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    }],
                    select: {
                        style: 'os',
                        selector: 'td:first-child'
                    },
                    paging: true,
                    lengthMenu: [[5, 6, 7, 8, 9, 10, 50, 100, -1], [5, 6, 7, 8, 9, 10, 50, 100, 'TOUTES']],
                    colReorder: {
                        realtime: false,
                    },
                    dom: 'lBfrtip',
                    responsive: true,
                    deferRender: true,
                    select: true,
                    buttons: [
                        {
                            extend: 'create',
                            editor: editor,
                            formButtons: [
                                'Creer',
                                {
                                    text: 'Annuler', action: function () {
                                        this.close();
                                    }
                                }
                            ]
                        },
                        {
                            extend: 'editSingle',
                            editor: editor,
                            formButtons: [
                                'Editer',
                                {
                                    text: 'Annuler', action: function () {
                                        this.close();
                                    }
                                }
                            ]
                        },
                        {
                            text: 'Supprimer',
                            extend: 'removeSingle',
                            editor: editor,

                        }
                    ], columns: [

                        {
                            data: null, render: function (data, type, row) {
                                return ``;
                            }
                        },// la donnee permission_id

                        {data: 'user_name'},
                        {data: 'permission_label'},
// la donnee model_type
//                         {data: 'model_type'},
// la donnee model_id

                    ],
                });
                that.table = table


                table.on('draw', function () {
                    console.log('on draw')
                    var body = $(table.table().body());

                    body.unhighlight();
                    if (table.rows({filter: 'applied'}).data().length) {
                        body.highlight(table.search());
                    }
                });
                $.extend(true, $.fn.dataTable.Editor.defaults, {
                    create: {
                        button: 'Nouveau',
                        title: 'Créer nouvelle entrée',
                        submit: 'Créer'
                    },

                    // ...
                });


                $('.buttons-create').addClass('btn btn-primary');
                $('.buttons-edit').addClass('btn btn-warning');
                $('.buttons-remove').addClass('btn btn-danger');
                editor.on('preOpen', function () {

                })
                editor.on('open', function () {
                    console.log('on ouvre le formulaire')
                    console.log('on veut deplacer  le formulaire')
                    $('.DTE_Form_Buttons .btn:eq(0)').addClass('btn-primary');
                    $('.DTE_Form_Buttons .btn:eq(1)').addClass('btn-danger');
                    that.show_table = false
                })
                editor.on('initSubmit', function (editor) {
                    console.log('je mapprete a soumettre les donnees')
                })
                editor.on('submitSuccess', function () {
                    console.log('je recharge les donnees')
                    that.table.ajax.reload();
                })
                editor.on('close', function () {
                    console.log('on ferme le formulaire')
                    that.show_table = true
                })
            }
        })

    </script>
@endsection
