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
    {{--    <style>--}}
    {{--        thead {--}}
    {{--            display: none--}}
    {{--        }--}}

    {{--        tbody {--}}
    {{--            display: flex;--}}
    {{--            gap: 20px;--}}
    {{--        }--}}

    {{--        tr {--}}
    {{--            width: 400px;--}}
    {{--            display: block;--}}
    {{--            padding: 0px;--}}
    {{--            background: none !important;--}}
    {{--        }--}}

    {{--        td {--}}
    {{--            padding: 0px !important;--}}

    {{--            border-top: 0px !important;--}}
    {{--        }--}}

    {{--        td .card {--}}
    {{--            margin: 0px !important;--}}
    {{--        }--}}

    {{--        .row-edit {--}}
    {{--            margin: 0px 10px;--}}
    {{--        }--}}
    {{--    </style>--}}
@endsection

@section('title','Gestion des roles')
@section('content')
    <div class="container">


        <div class="ui-block mb-3">
            <div class="ui-block-title bg-primary">
                <h5 class="title text-light titre">
                    <svg class='olymp-month-calendar-icon left-menu-icon' data-bs-toggle='tooltip'
                         data-bs-placement='right'>
                        <use xlink:href='#olymp-month-calendar-icon'></use>
                    </svg>
                    Les roles
                    <i id="new" class="fa fa-plus text-light" style="float: right"></i></h5>
            </div>


        </div>

    </div>



    <div class='container editor_enfant_box'>
        <div class="row">

        </div>


        {{--        <H2>listes des roles</H2>--}}
        <div id='app'>
            <div id='form'></div>
            <div id='app_vue' v-show='show_table'>
                <div class='tables'>
                    <table id='roles' class='display table table-striped' style='width:100%'>
                        <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>name</th>
                            <th>guard_name</th>
                            <th>Permissions</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div id='customForm' class='row'>
            {{--        <div class='col-md-12' data-editor-template='id'></div>--}}
            <div class='col-md-12' data-editor-template='name'></div>
            {{--        <div class='col-md-12' data-editor-template='guard_name'></div>--}}
            {{--        <div class='col-md-12' data-editor-template='created_at'></div>--}}
            {{--        <div class='col-md-12' data-editor-template='updated_at'></div>--}}

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

                $('#roles').css('width', '100%')
                let editor = new $.fn.dataTable.Editor({
                    ajax: {
                        url: 'Roles',
                        type: 'POST',
                    },
                    table: '#roles',
                    template: '#customForm',
                    display: onPageDisplay($('#form')),
                    fields: [
                        // le champs id
                        // {label: 'id :', name: 'id'},
                        // le champs name
                        {label: 'name :', name: 'name'},
                        // le champs guard_name
                        // {label: 'guard_name :', name: 'guard_name'},
                        // // le champs created_at
                        // {label: 'created_at :', name: 'created_at'},
                        // // le champs updated_at
                        // {label: 'updated_at :', name: 'updated_at'},

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
                let table = $('#roles').DataTable({
                    ajax: {
                        url: 'Roles',
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
                    paging: true,
                    lengthMenu: [[5, 6, 7, 8, 9, 10, 50, 100, -1], [5, 6, 7, 8, 9, 10, 50, 100, 'TOUTES']],
                    colReorder: {
                        realtime: false,
                    },
                    dom: 'lBfrtip',
                    responsive: true,
                    deferRender: true,
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
                        // {
                        //     extend: 'editSingle',
                        //     editor: editor,
                        //     formButtons: [
                        //         'Editer',
                        //         {
                        //             text: 'Annuler', action: function () {
                        //                 this.close();
                        //             }
                        //         }
                        //     ]
                        // },
                        // {
                        //     text: 'Supprimer',
                        //     extend: 'removeSingle',
                        //     editor: editor,
                        //
                        // }
                    ],
                    columns: [

                        {
                            data: null, render: function (data, type, row) {
                                return ``;
                            }
                        },// la donnee id
                        {data: 'id'},
                        //         {
                        //             data: null, render: function (data) {
                        //                 return `<div class="card">
                        //     <div class="card-body">
                        //         <div class="d-flex justify-content-between">
                        //             <span>Total 4 users</span>
                        //             <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                        //                 <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="" class="avatar avatar-sm pull-up" data-bs-original-title="Vinnie Mostowy">
                        //                     <img class="rounded-circle" src="../../../app-assets/images/avatars/2.png" alt="Avatar">
                        //                 </li>
                        //                 <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="" class="avatar avatar-sm pull-up" data-bs-original-title="Allen Rieske">
                        //                     <img class="rounded-circle" src="../../../app-assets/images/avatars/12.png" alt="Avatar">
                        //                 </li>
                        //                 <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="" class="avatar avatar-sm pull-up" data-bs-original-title="Julee Rossignol">
                        //                     <img class="rounded-circle" src="../../../app-assets/images/avatars/6.png" alt="Avatar">
                        //                 </li>
                        //                 <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="" class="avatar avatar-sm pull-up" data-bs-original-title="Kaith D'souza">
                        //                     <img class="rounded-circle" src="../../../app-assets/images/avatars/11.png" alt="Avatar">
                        //                 </li>
                        //             </ul>
                        //         </div>
                        //         <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                        //             <div class="role-heading">
                        //                 <h4 class="fw-bolder">${data.name}</h4>
                        //
                        //             </div>
                        //
                        // </div>
                        //         <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                        //                     <small class="fw-bolder">Creer le ${data.created_at}</small>
                        //
                        //
                        //     </div>
                        //         <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                        //                                  <small class="fw-bolder">Mise a jour le ${data.created_at}</small>
                        //
                        //
                        //     </div>
                        //         <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                        //                    <a href="Roles-${data}-permissions" class="link-primary"><button class="btn btn-primary">Voir</button></a>
                        //                  <button class="btn btn-warning row-edit">Editer</button>
                        //                   <button class="btn btn-danger row-delete">Supprimer</button>
                        //
                        //     </div>
                        // </div>`
                        //             }
                        //         },
// la donnee name
                        {data: 'name'},
// la donnee guard_name
                        {data: 'guard_name'},
                        {
                            data: 'id', render: function (data, type, row) {
                                return `<a href="Roles-${data}-permissions" class="link-primary"><button class="btn btn-primary">Voir</button></a>`;
                            }
                        },
// la donnee created_at
                        {data: 'created_at'},
// la donnee updated_at
                        {data: 'updated_at'},

                    ],

                    processing: true,
                    serverSide: true
                });
                that.table = table


                // Activate an inline edit on click of a table cell
                $('#roles').on('click', '.row-edit', function (e) {
                    editor.edit($(this).parents('tr'), {
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
                $('#roles').on('click', '.row-delete', function (e) {

                    editor.remove($(this).parents('tr'), {
                        title: 'Delete record',
                        message: 'Etes vous sur de voulor supprimer ce roles ?',
                        buttons: [{
                            text: 'Non', action: function () {
                                this.close();
                            }
                        },
                            'Oui'
                        ]
                    });
                });

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
