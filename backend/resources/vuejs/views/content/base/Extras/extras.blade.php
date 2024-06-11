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
    @livewireStyles

@endsection

@section('title',"extras")
@section('content')
    <div class="container">


    </div>


    <div id='app' class="container-fluid">


        <div id='form_extras'></div>


        <div id='app_vue' v-show='show_table'>

            <div class="col-md-12 ">
                <div class="col-sm-12 heading-bg">
                    <div class="card panel-heading" id="Extras_tables_boutons">

                    </div>

                    <div class="card">
                        <div class="card-header">
                            Les extras


                            @if(!request()->has('crud') || intval(request()->get('crud'))!=0)

                                <i id="new_extras" class="fa fa-plus " style="float: right"></i>
                            @endif
                        </div>
                        <div class="card-body">

                            <div id="Extras_parents" class='tables'>
                                <table id='Extras' class='display table table-striped' style='width:100%'>
                                    <thead>
                                    <tr>
                                        <th></th>


                                        <th>Libelle</th>


                                        <th>Types</th>


                                        <th>Text</th>


                                        <th>Files</th>


                                        <th>Textarea</th>


                                        <th>Datetime</th>


                                        {{-- <th>Created_at</th>--}}


                                        {{-- <th>Creer par</th>--}}


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

    <div id='customForm'>
        <div class="card-header">
            <h6 class="card-title"><i class="fa fa-user-md"></i> Manage Extras</h6>
        </div>
        <div class="card-body">


            <div class='col-md-12' data-editor-template='id'></div>


            <div class='col-md-12' data-editor-template='libelle'></div>


            <div class='col-md-12' data-editor-template='types'></div>


            <div class='col-md-12' data-editor-template='text'></div>


            <div class='col-md-12' data-editor-template='files'></div>


            <div class='col-md-12' data-editor-template='textarea'></div>


            <div class='col-md-12' data-editor-template='datetime'></div>


            <div class='col-md-12' data-editor-template='extra_attributes'></div>


            <div class='col-md-12' data-editor-template='deleted_at'></div>


            <div class='col-md-12' data-editor-template='created_at'></div>


            <div class='col-md-12' data-editor-template='updated_at'></div>


        </div>
    </div>

@endsection
@section('vendor-script')
    <!-- vendor files -->

@endsection
@section('page-script')
    @livewireScripts

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
            }
        });


    </script>







    <script>


        function Extras_onPageDisplay(elm) {
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

        let Extras_editor = new $.fn.dataTable.Editor({

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Extras_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Extras_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Extras_web_index')}}/_id_/delete"
                },
                cache: true

            },
            table: '#Extras',
            template: '#customForm',
            display: Extras_onPageDisplay($('#form_extras')),
            fields: [


                {


                    label: " Libelle:", name: "libelle"
                },


                {


                    label: " Types:", name: "types"
                },


                {


                    label: " Text:", name: "text"
                },


                {


                    label: "Files:",
                    titre: "Veuillez choisir votre fichier :",
                    name: "files",
                    type: "dropzone",
                    options: {
                        uploads_url: "{{route('web_uploads_files_general')}}",
                        files_url: "{{route('web_uploads_files_general_get_base')}}",
                        message: " Deposer le fichier a telecharger ",

                    },
                },


                {


                    label: " Textarea:", name: "textarea", type: "textarea"

                },


                {


                    label: " Datetime:", name: "datetime", type: "personnal_date"
                },


                // les parents


            ],
        });


        Extras_editor.on('preOpen', function () {
            $('#form_extras').addClass('card')
            $('#app_vue').hide()

        })
        Extras_editor.on('close', function () {
            $('#form_extras').removeClass('card')
            $('#app_vue').show()


        })

        Extras_editor.on('preOpen', function () {

        })
        Extras_editor.on('open', function () {
            console.log('on ouvre le formulaire')
            console.log('on veut deplacer  le formulaire')
            $('.DTE_Form_Buttons .btn:eq(0)').addClass('btn-primary');
            $('.DTE_Form_Buttons .btn:eq(1)').addClass('btn-danger');
            $('#Extras_parents').hide()
        })
        Extras_editor.on('initSubmit', function (editor) {
            console.log('je mapprete a soumettre les donnees')
        })
        Extras_editor.on('submitSuccess', function () {
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
        Extras_editor.on('close', function () {
            $('#Extras_parents').show()


        })


    </script>


    <script>


        let Extras_table = $('#Extras').DataTable({

            @if(request()->get('pkey') && request()->get('pval')  )
            ajax: {
                url: " {{ URL::signedRoute('Extras_web_index_data2',
            [
                'key'=> request()->get('pkey'),'val'=>request()->get('pval')]) }}",
                type: 'GET',
                cache: true

            }
            ,
            @elseif(!empty($Extras)   )
            ajax: {
                url: " {{ URL::signedRoute('Extras_web_index_data2',
            [
                'key'=> 'id','val'=>$Extras->id]) }}",
                type: 'GET',
                cache: true

            }
            ,
            @else
            ajax: {
                url: "{{ route('Extras_web_index')}}_data",
                type: 'GET',
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
            lengthMenu: [[5, 10, 50, 100], [5, 10, 50, 100]],
            colReorder: {
                realtime: false,
            },
            dom: 'lBfrtip',
            responsive: true,
            deferRender: true,
            buttons: [], columns: [

                {
                    data: null, render: function (data, type, row) {
                        return ``;
                    }
                },
                // {data: 'PipelinesAvf'},


                // la donnee id  {data: 'id'},
// la donnee label

                {
                    data: 'libelle'
                },


                {
                    data: 'types'
                },


                {
                    data: 'text'
                },


                {
                    data: 'FilesRender'
                },


                {
                    data: 'textarea'
                },


                {
                    data: 'datetime'
                },


                {
                    data: 'created_at'
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
                {data: 'CreateursCruds'},


                // {data: 'CardRender'},
                {
                    data: null, render: function (data, type, row) {
                        return `

                    @if(!request()->has('imprimer') || intval(request()->get('impression'))!=0)
                        <a href='${data.SignedImpressionUrl}'>
                        <button class='btn btn-success'> Imprimmer</button>
                    </a>
                    @endif
                        @if(!request()->has('voir') || intval(request()->get('voir'))!=0)
                        <a href='${data.SignedShowUrl}'>
                        <button class='btn btn-success'> Voir</button>
                    </a>
                    @endif
                        @if(!request()->has('crud') || intval(request()->get('crud'))!=0)
                        <button class='btn btn-success row-edit' data-url="${data.SignedEditUrl}"> Editer</button>
                        <button class='btn btn-success row-delete' data-url="${data.SignedDeleteUrl}"> Supprimer</button>
                    @endif
                        `;
                    }
                },

            ],
            processing: true,
            serverSide: true,
        });


        Extras_table.on('draw', function () {
            console.log('on draw')
            var body = $(Extras_table.table().body());
            window.livewire.rescan()

            body.unhighlight();
            if (Extras_table.rows({filter: 'applied'}).data().length) {
                body.highlight(Extras_table.search());
            }
        });


        // Activate an inline edit on click of a table cell
        $('#Extras').on('click', '.row-edit', function (e) {
            let parent = $($(this).parents("tr"))
            let tr;
            if (parent.hasClass('child')) {

                tr = parent.prev()
            } else {
                tr = parent
            }

            Extras_editor.edit(tr, {
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
        $('#Extras').on('click', '.row-delete', function (e) {

            let parent = $($(this).parents("tr"))
            let tr;
            if (parent.hasClass('child')) {

                tr = parent.prev()
            } else {
                tr = parent
            }
            Extras_editor.remove(tr, {
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


        $('#new_extras').on('click', function (e) {

            Extras_editor.create().buttons([
                'Creer',
                {
                    text: 'Annuler', action: function () {
                        this.close();
                    }
                }
            ]).open();
        });
        $('.buttons-create').addClass('btn btn-primary');
        $('.buttons-edit').addClass('btn btn-warning');
        $('.buttons-remove').addClass('btn btn-danger');
        $('#Extras_wrapper').children('.dt-buttons').appendTo($('#Extras_tables_boutons'));


    </script>

@endsection
