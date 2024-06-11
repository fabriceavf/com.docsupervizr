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

@section('title','users')
@section('content')
    <div class="container">


        <div class="ui-block mb-3">
            <div class="ui-block-title bg-primary">
                <h5 class="title text-light titre">
                    <svg class='olymp-month-calendar-icon left-menu-icon' data-bs-toggle='tooltip'
                         data-bs-placement='right'>
                        <use xlink:href='#olymp-month-calendar-icon'></use>
                    </svg>
                    Les users
                    <i id="new" class="fa fa-plus text-light" style="float: right"></i></h5>
            </div>


        </div>

    </div>





    <div class='container editor_enfant_box'>
        {{--        <H2>listes des users</H2>--}}
        <div id='app'>
            <div id='form'></div>
            <div id='app_vue' v-show='show_table'>

                <div class='tables'>
                    <table id='users' class='display table table-striped' style='width:100%'>
                        <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
                            <th>name</th>
                            <th>prenoms</th>
                            <th>email</th>
                            {{--                        <th>email_verified_at</th>--}}
                            <th>permissions</th>
                            {{--                        <th>remember_token</th>--}}
                            <th>Creer le</th>
                            <th>Modifier le</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div id='customForm' class='row'>
            <div class='col-md-12' data-editor-template='id'></div>
            <div class='col-md-12' data-editor-template='name'></div>
            <div class='col-md-12' data-editor-template='prenoms'></div>
            <div class='col-md-12' data-editor-template='contact'></div>
            <div class='col-md-12' data-editor-template='email'></div>
            <div class='col-md-12' data-editor-template='email_verified_at'></div>
            <div class='col-md-12' data-editor-template='password'></div>
            <div class='col-md-12' data-editor-template='password_confirm'></div>
            <div class='col-md-12' data-editor-template='date_naissance'></div>

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

                $('#users').css('width', '100%')
                let editor = new $.fn.dataTable.Editor({
                    ajax: {
                        url: '{{route("web_index_users_posts")}}',
                        type: 'POST',
                    },
                    table: '#users',
                    template: '#customForm',
                    display: onPageDisplay($('#form')),
                    fields: [
                        // le champs id
                        // {label: 'id :', name: 'id'},
                        // le champs name
                        {label: 'name :', name: 'name'},
                        // le champs prenoms
                        {label: 'prenoms :', name: 'prenoms'},
                        // le champs email
                        {label: 'email :', name: 'email'},
                        // le champs contact
                        {label: 'contact :', name: 'contact'},
                        {label: 'Date de naissance :', name: 'date_naissance', type: "personnal_date"},
                        // le champs email_verified_at
                        // {label: 'email_verified_at :', name: 'email_verified_at'},
                        // le champs password
                        {label: 'password :', name: 'password', type: "password"},
                        {label: 'password :', name: 'password_confirm', type: "password"},
                        // le champs add_by
                        // {label: 'add_by :', name: 'add_by'},
                        // le champs remember_token
                        // {label: 'remember_token :', name: 'remember_token'},
                        // // le champs created_at
                        // {label: 'created_at :', name: 'created_at'},
                        // // le champs updated_at
                        // {label: 'updated_at :', name: 'updated_at'},

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
                let table = $('#users').DataTable({
                    ajax: {
                        url: '{{route("web_index_users_posts")}}',
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
                    lengthMenu: [[9, 10, 50, 100, -1], [9, 10, 50, 100, 'TOUTES']],
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
                            data: 'id', render: function (data, type, row) {
                                return ``;
                            }
                        },// la donnee id
                        {data: 'id'},
// la donnee name
                        {data: 'name'},
// la donnee prenoms
                        {data: 'prenoms'},
// la donnee email
                        {data: 'email'},
// la donnee email_verified_at
//                         {data: 'email_verified_at'},
// la donnee password
                        {data: 'permissions', render: "[, ]"},
// la donnee add_by
// la donnee type
//                         {data: 'type'},
// la donnee remember_token
//                         {data: 'remember_token'},
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
