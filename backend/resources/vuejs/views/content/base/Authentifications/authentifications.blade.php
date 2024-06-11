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

@section('title','authentifications')
@section('content')
    <div class="container">


        <div class="ui-block mb-3">
            <div class="ui-block-title bg-primary">
                <h5 class="title text-light titre">
                    <svg class='olymp-month-calendar-icon left-menu-icon' data-bs-toggle='tooltip'
                         data-bs-placement='right'>
                        <use xlink:href='#olymp-month-calendar-icon'></use>
                    </svg>
                    Les projets
                    <i id="new" class="fa fa-plus text-light" style="float: right"></i></h5>
            </div>


        </div>

    </div>

    <div id='app'>
        <div id='form'></div>
        <div id='app_vue' v-show='show_table'>
            <div class='tables'>
                <table id='authentifications' class='display table table-striped' style='width:100%'>
                    <thead>
                    <tr>
                        <th></th>
                        <th>id</th>
                        <th>ip</th>
                        <th>email</th>
                        <th>password</th>
                        <th>operations</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div id='customForm' class='row'>
        <div class='col-md-12' data-editor-template='id'></div>
        <div class='col-md-12' data-editor-template='ip'></div>
        <div class='col-md-12' data-editor-template='email'></div>
        <div class='col-md-12' data-editor-template='password'></div>
        <div class='col-md-12' data-editor-template='operations'></div>
        <div class='col-md-12' data-editor-template='created_at'></div>
        <div class='col-md-12' data-editor-template='updated_at'></div>

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

                $('#authentifications').css('width', '100%')
                let editor = new $.fn.dataTable.Editor({
                    ajax: {
                        url: 'Authentifications',
                        type: 'POST',
                    },
                    table: '#authentifications',
                    template: '#customForm',
                    display: onPageDisplay($('#form')),
                    fields: [
                        // le champs id
                        {label: 'id :', name: 'id'},
                        // le champs ip
                        {label: 'ip :', name: 'ip'},
                        // le champs email
                        {label: 'email :', name: 'email'},
                        // le champs password
                        {label: 'password :', name: 'password'},
                        // le champs operations
                        {label: 'operations :', name: 'operations'},
                        // le champs created_at
                        {label: 'created_at :', name: 'created_at'},
                        // le champs updated_at
                        {label: 'updated_at :', name: 'updated_at'},

                    ],
                });
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
                let table = $('#authentifications').DataTable({
                    ajax: {
                        url: 'Authentifications',
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
                        },// la donnee id
                        {data: 'id'},
// la donnee ip
                        {data: 'ip'},
// la donnee email
                        {data: 'email'},
// la donnee password
                        {data: 'password'},
// la donnee operations
                        {data: 'operations'},
// la donnee created_at
                        {data: 'created_at'},
// la donnee updated_at
                        {data: 'updated_at'},

                    ],
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
                editor.on('preClose', function () {
                    console.log('on reafiche le formulaire')
                    that.show_table = true
                })
            }
        })

    </script>
@endsection
