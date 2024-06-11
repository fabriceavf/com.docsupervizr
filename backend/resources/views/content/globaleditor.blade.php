<script>

    let All_Editor = {};
    let All_Table = {}
    let All_Child = {}


</script>
<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Calendriers_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Calendriers_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Calendriers_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Calendriers_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Libelle:", name: "libelle"

            },


            {


                label: " Type:", name: "type"

            },


            {


                label: " Description:", name: "description"

            },


        ]
        ,
    };
    let Config_Calendriers_childs = []


    let Config_Calendriers_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Calendriers_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'libelle'
            },


            {
                data: 'type'
            },


            {
                data: 'description'
            },


        ],
    };
    All_Table["calendriers"] = Config_Calendriers_table_{{$__internalId__}}
        All_Editor["calendriers"] = Config_Calendriers_editor_{{$__internalId__}}
        All_Child["calendriers"] = Config_Calendriers_childs


    function CalendriersGeneralEditor(position, config, Functions) {

        let fieldCalendriers = [


            {


                label: " Libelle:", name: "libelle"
                @if(request()->has('__key__libelle'))
                , def: "{{request()->get('__key__libelle')}}"
                @endif
            },


            {


                label: " Type:", name: "type"
                @if(request()->has('__key__type'))
                , def: "{{request()->get('__key__type')}}"
                @endif
            },


            {


                label: " Description:", name: "description"
                @if(request()->has('__key__description'))
                , def: "{{request()->get('__key__description')}}"
                @endif
            },


        ];
        let fieldCalendriersConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Calendriers_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Calendriers_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Calendriers_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Calendriers_{{$__internalId__}}_customForm_general',
            display: Calendriers_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldCalendriers,
        };

        fieldCalendriersConfig = $.extend(fieldCalendriersConfig, config)

        function Calendriers_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Calendriers_general_editor = new $.fn.dataTable.Editor(fieldCalendriersConfig);
        return Calendriers_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Fonctions_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Fonctions_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Fonctions_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Fonctions_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Code:", name: "code"

            },


            {


                label: " Libelle:", name: "libelle"

            },


            {
                label: "Services:", name: "service_id", type: "select1", entite: 'services'
            },


        ]
        ,
    };
    let Config_Fonctions_childs = [
        "users",

    ]


    let Config_Fonctions_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Fonctions_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'code'
            },


            {
                data: 'libelle'
            },


            {
                data: 'service_id'
            },


        ],
    };
    All_Table["fonctions"] = Config_Fonctions_table_{{$__internalId__}}
        All_Editor["fonctions"] = Config_Fonctions_editor_{{$__internalId__}}
        All_Child["fonctions"] = Config_Fonctions_childs


    function FonctionsGeneralEditor(position, config, Functions) {

        let fieldFonctions = [


            {


                label: " Code:", name: "code"
                @if(request()->has('__key__code'))
                , def: "{{request()->get('__key__code')}}"
                @endif
            },


            {


                label: " Libelle:", name: "libelle"
                @if(request()->has('__key__libelle'))
                , def: "{{request()->get('__key__libelle')}}"
                @endif
            },


                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="service_id"   )


            {


                label: "Services:",
                name: "service_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Services:", name: "service_id", type: "select1", entite: 'services'
            },

            @endif







        ];
        let fieldFonctionsConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Fonctions_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Fonctions_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Fonctions_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Fonctions_{{$__internalId__}}_customForm_general',
            display: Fonctions_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldFonctions,
        };

        fieldFonctionsConfig = $.extend(fieldFonctionsConfig, config)

        function Fonctions_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Fonctions_general_editor = new $.fn.dataTable.Editor(fieldFonctionsConfig);
        return Fonctions_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Horaires_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Horaires_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Horaires_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Horaires_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Libelle:", name: "libelle"

            },


            {


                label: " Debut:", name: "debut"

            },


            {


                label: " Fin:", name: "fin"

            },


            {


                label: " Type:", name: "type"

            },


            {


                label: " Ecart_debut:", name: "ecart_debut"

            },


            {


                label: " Ecart_fin:", name: "ecart_fin"

            },


            {
                label: "Taches:", name: "tache_id", type: "select1", entite: 'taches'
            },


        ]
        ,
    };
    let Config_Horaires_childs = []


    let Config_Horaires_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Horaires_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'libelle'
            },


            {
                data: 'debut'
            },


            {
                data: 'fin'
            },


            {
                data: 'type'
            },


            {
                data: 'tache_id'
            },


            {
                data: 'ecart_debut'
            },


            {
                data: 'ecart_fin'
            },


        ],
    };
    All_Table["horaires"] = Config_Horaires_table_{{$__internalId__}}
        All_Editor["horaires"] = Config_Horaires_editor_{{$__internalId__}}
        All_Child["horaires"] = Config_Horaires_childs


    function HorairesGeneralEditor(position, config, Functions) {

        let fieldHoraires = [


            {


                label: " Libelle:", name: "libelle"
                @if(request()->has('__key__libelle'))
                , def: "{{request()->get('__key__libelle')}}"
                @endif
            },


            {


                label: " Debut:", name: "debut"
                @if(request()->has('__key__debut'))
                , def: "{{request()->get('__key__debut')}}"
                @endif
            },


            {


                label: " Fin:", name: "fin"
                @if(request()->has('__key__fin'))
                , def: "{{request()->get('__key__fin')}}"
                @endif
            },


            {


                label: " Type:", name: "type"
                @if(request()->has('__key__type'))
                , def: "{{request()->get('__key__type')}}"
                @endif
            },


            {


                label: " Ecart_debut:", name: "ecart_debut"
                @if(request()->has('__key__ecart_debut'))
                , def: "{{request()->get('__key__ecart_debut')}}"
                @endif
            },


            {


                label: " Ecart_fin:", name: "ecart_fin"
                @if(request()->has('__key__ecart_fin'))
                , def: "{{request()->get('__key__ecart_fin')}}"
                @endif
            },


                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="tache_id"   )


            {


                label: "Taches:",
                name: "tache_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Taches:", name: "tache_id", type: "select1", entite: 'taches'
            },

            @endif







        ];
        let fieldHorairesConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Horaires_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Horaires_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Horaires_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Horaires_{{$__internalId__}}_customForm_general',
            display: Horaires_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldHoraires,
        };

        fieldHorairesConfig = $.extend(fieldHorairesConfig, config)

        function Horaires_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Horaires_general_editor = new $.fn.dataTable.Editor(fieldHorairesConfig);
        return Horaires_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Nations_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Nations_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Nations_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Nations_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Libelle:", name: "libelle"

            },


        ]
        ,
    };
    let Config_Nations_childs = []


    let Config_Nations_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Nations_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'libelle'
            },


        ],
    };
    All_Table["nations"] = Config_Nations_table_{{$__internalId__}}
        All_Editor["nations"] = Config_Nations_editor_{{$__internalId__}}
        All_Child["nations"] = Config_Nations_childs


    function NationsGeneralEditor(position, config, Functions) {

        let fieldNations = [


            {


                label: " Libelle:", name: "libelle"
                @if(request()->has('__key__libelle'))
                , def: "{{request()->get('__key__libelle')}}"
                @endif
            },


        ];
        let fieldNationsConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Nations_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Nations_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Nations_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Nations_{{$__internalId__}}_customForm_general',
            display: Nations_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldNations,
        };

        fieldNationsConfig = $.extend(fieldNationsConfig, config)

        function Nations_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Nations_general_editor = new $.fn.dataTable.Editor(fieldNationsConfig);
        return Nations_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Pointages_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Pointages_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Pointages_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Pointages_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Pointeuse:", name: "pointeuse"

            },


            {


                label: " Lieu:", name: "lieu"

            },


            {


                label: " Debut_prevu:", name: "debut_prevu"

            },


            {


                label: " Fin_prevu:", name: "fin_prevu"

            },


            {


                label: " Faction_horaire:", name: "faction_horaire"

            },


            {


                label: " Debut_realise:", name: "debut_realise"

            },


            {


                label: " Fin_realise:", name: "fin_realise"

            },


            {


                label: " Volume_realise:", name: "volume_realise"

            },


            {


                label: " Emp_code:", name: "emp_code"

            },


            {


                label: " Actif:", name: "actif"

            },


            {


                label: " Est_valide:", name: "est_valide"

            },


            {


                label: " Est_attendu:", name: "est_attendu"

            },


            {
                label: "Users:", name: "user_id", type: "select1", entite: 'users'
            },


        ]
        ,
    };
    let Config_Pointages_childs = []


    let Config_Pointages_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Pointages_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'pointeuse'
            },


            {
                data: 'lieu'
            },


            {
                data: 'debut_prevu'
            },


            {
                data: 'fin_prevu'
            },


            {
                data: 'faction_horaire'
            },


            {
                data: 'debut_realise'
            },


            {
                data: 'fin_realise'
            },


            {
                data: 'volume_realise'
            },


            {
                data: 'emp_code'
            },


            {
                data: 'actif'
            },


            {
                data: 'est_valide'
            },


            {
                data: 'est_attendu'
            },


            {
                data: 'user_id'
            },


        ],
    };
    All_Table["pointages"] = Config_Pointages_table_{{$__internalId__}}
        All_Editor["pointages"] = Config_Pointages_editor_{{$__internalId__}}
        All_Child["pointages"] = Config_Pointages_childs


    function PointagesGeneralEditor(position, config, Functions) {

        let fieldPointages = [


            {


                label: " Pointeuse:", name: "pointeuse"
                @if(request()->has('__key__pointeuse'))
                , def: "{{request()->get('__key__pointeuse')}}"
                @endif
            },


            {


                label: " Lieu:", name: "lieu"
                @if(request()->has('__key__lieu'))
                , def: "{{request()->get('__key__lieu')}}"
                @endif
            },


            {


                label: " Debut_prevu:", name: "debut_prevu"
                @if(request()->has('__key__debut_prevu'))
                , def: "{{request()->get('__key__debut_prevu')}}"
                @endif
            },


            {


                label: " Fin_prevu:", name: "fin_prevu"
                @if(request()->has('__key__fin_prevu'))
                , def: "{{request()->get('__key__fin_prevu')}}"
                @endif
            },


            {


                label: " Faction_horaire:", name: "faction_horaire"
                @if(request()->has('__key__faction_horaire'))
                , def: "{{request()->get('__key__faction_horaire')}}"
                @endif
            },


            {


                label: " Debut_realise:", name: "debut_realise"
                @if(request()->has('__key__debut_realise'))
                , def: "{{request()->get('__key__debut_realise')}}"
                @endif
            },


            {


                label: " Fin_realise:", name: "fin_realise"
                @if(request()->has('__key__fin_realise'))
                , def: "{{request()->get('__key__fin_realise')}}"
                @endif
            },


            {


                label: " Volume_realise:", name: "volume_realise"
                @if(request()->has('__key__volume_realise'))
                , def: "{{request()->get('__key__volume_realise')}}"
                @endif
            },


            {


                label: " Emp_code:", name: "emp_code"
                @if(request()->has('__key__emp_code'))
                , def: "{{request()->get('__key__emp_code')}}"
                @endif
            },


            {


                label: " Actif:", name: "actif"
                @if(request()->has('__key__actif'))
                , def: "{{request()->get('__key__actif')}}"
                @endif
            },


            {


                label: " Est_valide:", name: "est_valide"
                @if(request()->has('__key__est_valide'))
                , def: "{{request()->get('__key__est_valide')}}"
                @endif
            },


            {


                label: " Est_attendu:", name: "est_attendu"
                @if(request()->has('__key__est_attendu'))
                , def: "{{request()->get('__key__est_attendu')}}"
                @endif
            },


                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="user_id"   )


            {


                label: "Users:",
                name: "user_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Users:", name: "user_id", type: "select1", entite: 'users'
            },

            @endif







        ];
        let fieldPointagesConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Pointages_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Pointages_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Pointages_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Pointages_{{$__internalId__}}_customForm_general',
            display: Pointages_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldPointages,
        };

        fieldPointagesConfig = $.extend(fieldPointagesConfig, config)

        function Pointages_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Pointages_general_editor = new $.fn.dataTable.Editor(fieldPointagesConfig);
        return Pointages_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Programmations_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Programmations_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Programmations_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Programmations_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Semaine:", name: "semaine"

            },


            {


                label: " Superviseur:", name: "superviseur"

            },


            {


                label: " Statut:", name: "statut", def: '0', type: 'hidden'
            },


            {


                label: " Actif:", name: "actif"

            },


            {
                label: "Taches:", name: "tache_id", type: "select1", entite: 'taches'
            },


        ]
        ,
    };
    let Config_Programmations_childs = [
        "programmes",

    ]


    let Config_Programmations_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Programmations_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'semaine'
            },


            {
                data: 'superviseur'
            },


            {
                data: 'actif'
            },


            {
                data: 'tache_id'
            },


        ],
    };
    All_Table["programmations"] = Config_Programmations_table_{{$__internalId__}}
        All_Editor["programmations"] = Config_Programmations_editor_{{$__internalId__}}
        All_Child["programmations"] = Config_Programmations_childs


    function ProgrammationsGeneralEditor(position, config, Functions) {

        let fieldProgrammations = [


            {


                label: " Semaine:", name: "semaine"
                @if(request()->has('__key__semaine'))
                , def: "{{request()->get('__key__semaine')}}"
                @endif
            },


            {


                label: " Superviseur:", name: "superviseur"
                @if(request()->has('__key__superviseur'))
                , def: "{{request()->get('__key__superviseur')}}"
                @endif
            },


            {


                label: " Statut:", name: "statut", def: '0', type: 'hidden'
            },


            {


                label: " Actif:", name: "actif"
                @if(request()->has('__key__actif'))
                , def: "{{request()->get('__key__actif')}}"
                @endif
            },


                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="tache_id"   )


            {


                label: "Taches:",
                name: "tache_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Taches:", name: "tache_id", type: "select1", entite: 'taches'
            },

            @endif







        ];
        let fieldProgrammationsConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Programmations_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Programmations_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Programmations_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Programmations_{{$__internalId__}}_customForm_general',
            display: Programmations_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldProgrammations,
        };

        fieldProgrammationsConfig = $.extend(fieldProgrammationsConfig, config)

        function Programmations_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Programmations_general_editor = new $.fn.dataTable.Editor(fieldProgrammationsConfig);
        return Programmations_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Programmes_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Programmes_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Programmes_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Programmes_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Dimanche:", name: "dimanche"

            },


            {


                label: " Lundi:", name: "lundi"

            },


            {


                label: " Mardi:", name: "mardi"

            },


            {


                label: " Mercredi:", name: "mercredi"

            },


            {


                label: " Jeudi:", name: "jeudi"

            },


            {


                label: " Vendredi:", name: "vendredi"

            },


            {


                label: " Samedi:", name: "samedi"

            },


            {


                label: " Statut:", name: "statut", def: '0', type: 'hidden'
            },


            {


                label: " Actif:", name: "actif"

            },


            {
                label: "Programmations:", name: "programmation_id", type: "select1", entite: 'programmations'
            },


            {
                label: "Users:", name: "user_id", type: "select1", entite: 'users'
            },


        ]
        ,
    };
    let Config_Programmes_childs = []


    let Config_Programmes_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Programmes_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'dimanche'
            },


            {
                data: 'lundi'
            },


            {
                data: 'mardi'
            },


            {
                data: 'mercredi'
            },


            {
                data: 'jeudi'
            },


            {
                data: 'vendredi'
            },


            {
                data: 'samedi'
            },


            {
                data: 'actif'
            },


            {
                data: 'programmation_id'
            },


            {
                data: 'user_id'
            },


        ],
    };
    All_Table["programmes"] = Config_Programmes_table_{{$__internalId__}}
        All_Editor["programmes"] = Config_Programmes_editor_{{$__internalId__}}
        All_Child["programmes"] = Config_Programmes_childs


    function ProgrammesGeneralEditor(position, config, Functions) {

        let fieldProgrammes = [


            {


                label: " Dimanche:", name: "dimanche"
                @if(request()->has('__key__dimanche'))
                , def: "{{request()->get('__key__dimanche')}}"
                @endif
            },


            {


                label: " Lundi:", name: "lundi"
                @if(request()->has('__key__lundi'))
                , def: "{{request()->get('__key__lundi')}}"
                @endif
            },


            {


                label: " Mardi:", name: "mardi"
                @if(request()->has('__key__mardi'))
                , def: "{{request()->get('__key__mardi')}}"
                @endif
            },


            {


                label: " Mercredi:", name: "mercredi"
                @if(request()->has('__key__mercredi'))
                , def: "{{request()->get('__key__mercredi')}}"
                @endif
            },


            {


                label: " Jeudi:", name: "jeudi"
                @if(request()->has('__key__jeudi'))
                , def: "{{request()->get('__key__jeudi')}}"
                @endif
            },


            {


                label: " Vendredi:", name: "vendredi"
                @if(request()->has('__key__vendredi'))
                , def: "{{request()->get('__key__vendredi')}}"
                @endif
            },


            {


                label: " Samedi:", name: "samedi"
                @if(request()->has('__key__samedi'))
                , def: "{{request()->get('__key__samedi')}}"
                @endif
            },


            {


                label: " Statut:", name: "statut", def: '0', type: 'hidden'
            },


            {


                label: " Actif:", name: "actif"
                @if(request()->has('__key__actif'))
                , def: "{{request()->get('__key__actif')}}"
                @endif
            },


                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="programmation_id"   )


            {


                label: "Programmations:",
                name: "programmation_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Programmations:", name: "programmation_id", type: "select1", entite: 'programmations'
            },

                @endif
                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="user_id"   )


            {


                label: "Users:",
                name: "user_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Users:", name: "user_id", type: "select1", entite: 'users'
            },

            @endif







        ];
        let fieldProgrammesConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Programmes_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Programmes_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Programmes_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Programmes_{{$__internalId__}}_customForm_general',
            display: Programmes_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldProgrammes,
        };

        fieldProgrammesConfig = $.extend(fieldProgrammesConfig, config)

        function Programmes_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Programmes_general_editor = new $.fn.dataTable.Editor(fieldProgrammesConfig);
        return Programmes_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Services_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Services_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Services_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Services_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Code:", name: "code"

            },


            {


                label: " Libelle:", name: "libelle"

            },


        ]
        ,
    };
    let Config_Services_childs = [
        "fonctions",

    ]


    let Config_Services_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Services_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'code'
            },


            {
                data: 'libelle'
            },


        ],
    };
    All_Table["services"] = Config_Services_table_{{$__internalId__}}
        All_Editor["services"] = Config_Services_editor_{{$__internalId__}}
        All_Child["services"] = Config_Services_childs


    function ServicesGeneralEditor(position, config, Functions) {

        let fieldServices = [


            {


                label: " Code:", name: "code"
                @if(request()->has('__key__code'))
                , def: "{{request()->get('__key__code')}}"
                @endif
            },


            {


                label: " Libelle:", name: "libelle"
                @if(request()->has('__key__libelle'))
                , def: "{{request()->get('__key__libelle')}}"
                @endif
            },


        ];
        let fieldServicesConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Services_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Services_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Services_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Services_{{$__internalId__}}_customForm_general',
            display: Services_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldServices,
        };

        fieldServicesConfig = $.extend(fieldServicesConfig, config)

        function Services_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Services_general_editor = new $.fn.dataTable.Editor(fieldServicesConfig);
        return Services_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Taches_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Taches_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Taches_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Taches_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Type:", name: "type"

            },


            {


                label: " Libelle:", name: "libelle"

            },


            {
                label: "Villes:", name: "ville_id", type: "select1", entite: 'villes'
            },


        ]
        ,
    };
    let Config_Taches_childs = [
        "horaires",
        "programmations",

    ]


    let Config_Taches_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Taches_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'type'
            },


            {
                data: 'libelle'
            },


            {
                data: 'ville_id'
            },


        ],
    };
    All_Table["taches"] = Config_Taches_table_{{$__internalId__}}
        All_Editor["taches"] = Config_Taches_editor_{{$__internalId__}}
        All_Child["taches"] = Config_Taches_childs


    function TachesGeneralEditor(position, config, Functions) {

        let fieldTaches = [


            {


                label: " Type:", name: "type"
                @if(request()->has('__key__type'))
                , def: "{{request()->get('__key__type')}}"
                @endif
            },


            {


                label: " Libelle:", name: "libelle"
                @if(request()->has('__key__libelle'))
                , def: "{{request()->get('__key__libelle')}}"
                @endif
            },


                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="ville_id"   )


            {


                label: "Villes:",
                name: "ville_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Villes:", name: "ville_id", type: "select1", entite: 'villes'
            },

            @endif







        ];
        let fieldTachesConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Taches_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Taches_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Taches_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Taches_{{$__internalId__}}_customForm_general',
            display: Taches_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldTaches,
        };

        fieldTachesConfig = $.extend(fieldTachesConfig, config)

        function Taches_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Taches_general_editor = new $.fn.dataTable.Editor(fieldTachesConfig);
        return Taches_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Transactions_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Transactions_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Transactions_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Transactions_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Area_alias:", name: "area_alias"

            },


            {


                label: " First_name:", name: "first_name"

            },


            {


                label: " Last_name:", name: "last_name"

            },


            {


                label: " Card_no:", name: "card_no"

            },


            {


                label: " Terminal_alias:", name: "terminal_alias"

            },


            {


                label: " Emp_code:", name: "emp_code"

            },


            {


                label: " Punch_date:", name: "punch_date"

            },


            {


                label: " Punch_time:", name: "punch_time"

            },


        ]
        ,
    };
    let Config_Transactions_childs = []


    let Config_Transactions_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Transactions_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'bio_id'
            },


            {
                data: 'area_alias'
            },


            {
                data: 'first_name'
            },


            {
                data: 'last_name'
            },


            {
                data: 'card_no'
            },


            {
                data: 'terminal_alias'
            },


            {
                data: 'emp_code'
            },


            {
                data: 'punch_date'
            },


            {
                data: 'punch_time'
            },


        ],
    };
    All_Table["transactions"] = Config_Transactions_table_{{$__internalId__}}
        All_Editor["transactions"] = Config_Transactions_editor_{{$__internalId__}}
        All_Child["transactions"] = Config_Transactions_childs


    function TransactionsGeneralEditor(position, config, Functions) {

        let fieldTransactions = [


            {


                label: " Area_alias:", name: "area_alias"
                @if(request()->has('__key__area_alias'))
                , def: "{{request()->get('__key__area_alias')}}"
                @endif
            },


            {


                label: " First_name:", name: "first_name"
                @if(request()->has('__key__first_name'))
                , def: "{{request()->get('__key__first_name')}}"
                @endif
            },


            {


                label: " Last_name:", name: "last_name"
                @if(request()->has('__key__last_name'))
                , def: "{{request()->get('__key__last_name')}}"
                @endif
            },


            {


                label: " Card_no:", name: "card_no"
                @if(request()->has('__key__card_no'))
                , def: "{{request()->get('__key__card_no')}}"
                @endif
            },


            {


                label: " Terminal_alias:", name: "terminal_alias"
                @if(request()->has('__key__terminal_alias'))
                , def: "{{request()->get('__key__terminal_alias')}}"
                @endif
            },


            {


                label: " Emp_code:", name: "emp_code"
                @if(request()->has('__key__emp_code'))
                , def: "{{request()->get('__key__emp_code')}}"
                @endif
            },


            {


                label: " Punch_date:", name: "punch_date"
                @if(request()->has('__key__punch_date'))
                , def: "{{request()->get('__key__punch_date')}}"
                @endif
            },


            {


                label: " Punch_time:", name: "punch_time"
                @if(request()->has('__key__punch_time'))
                , def: "{{request()->get('__key__punch_time')}}"
                @endif
            },


        ];
        let fieldTransactionsConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Transactions_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Transactions_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Transactions_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Transactions_{{$__internalId__}}_customForm_general',
            display: Transactions_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldTransactions,
        };

        fieldTransactionsConfig = $.extend(fieldTransactionsConfig, config)

        function Transactions_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Transactions_general_editor = new $.fn.dataTable.Editor(fieldTransactionsConfig);
        return Transactions_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Users_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Users_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Users_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Users_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Name:", name: "name"

            },


            {


                label: " Email:", name: "email"

            },


            {


                label: " Password:", name: "password"

            },


            {


                label: " Matricule:", name: "matricule"

            },


            {


                label: " Emp_code:", name: "emp_code"

            },


            {


                label: " Nom:", name: "nom"

            },


            {


                label: " Prenom:", name: "prenom"

            },


            {


                label: " Num_badge:", name: "num_badge"

            },


            {


                label: " Date_naissance:", name: "date_naissance"

            },


            {


                label: " Num_cnss:", name: "num_cnss"

            },


            {


                label: " Num_cnamgs:", name: "num_cnamgs"

            },


            {


                label: " Telephone1:", name: "telephone1"

            },


            {


                label: " Telephone2:", name: "telephone2"

            },


            {


                label: " Nationalite:", name: "nationalite"

            },


            {


                label: " Nombre_enfant:", name: "nombre_enfant"

            },


            {


                label: " Photo:", name: "photo"

            },


            {


                label: " Actif:", name: "actif"

            },


            {


                label: " En_ligne:", name: "en_ligne"

            },


            {


                label: " Date_embauche:", name: "date_embauche"

            },


            {


                label: " Sexe:", name: "sexe"

            },


            {


                label: " Type:", name: "type"

            },


            {


                label: " Situation:", name: "situation"

            },


            {


                label: " Situation_matri:", name: "situation_matri"

            },


            {
                label: "Fonctions:", name: "fonction_id", type: "select1", entite: 'fonctions'
            },


            {
                label: "Users:", name: "user_id", type: "select1", entite: 'users'
            },


        ]
        ,
    };
    let Config_Users_childs = [
        "pointages",
        "programmes",
        "users",
        "ventilations",
        "ventilationsdetails",

    ]


    let Config_Users_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Users_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'name'
            },


            {
                data: 'email'
            },


            {
                data: 'password'
            },


            {
                data: 'matricule'
            },


            {
                data: 'emp_code'
            },


            {
                data: 'nom'
            },


            {
                data: 'prenom'
            },


            {
                data: 'num_badge'
            },


            {
                data: 'date_naissance'
            },


            {
                data: 'num_cnss'
            },


            {
                data: 'num_cnamgs'
            },


            {
                data: 'telephone1'
            },


            {
                data: 'telephone2'
            },


            {
                data: 'nationalite'
            },


            {
                data: 'nombre_enfant'
            },


            {
                data: 'photo'
            },


            {
                data: 'actif'
            },


            {
                data: 'en_ligne'
            },


            {
                data: 'date_embauche'
            },


            {
                data: 'sexe'
            },


            {
                data: 'type'
            },


            {
                data: 'situation'
            },


            {
                data: 'situation_matri'
            },


            {
                data: 'fonction_id'
            },


            {
                data: 'user_id'
            },


        ],
    };
    All_Table["users"] = Config_Users_table_{{$__internalId__}}
        All_Editor["users"] = Config_Users_editor_{{$__internalId__}}
        All_Child["users"] = Config_Users_childs


    function UsersGeneralEditor(position, config, Functions) {

        let fieldUsers = [


            {


                label: " Name:", name: "name"
                @if(request()->has('__key__name'))
                , def: "{{request()->get('__key__name')}}"
                @endif
            },


            {


                label: " Email:", name: "email"
                @if(request()->has('__key__email'))
                , def: "{{request()->get('__key__email')}}"
                @endif
            },


            {


                label: " Password:", name: "password"
                @if(request()->has('__key__password'))
                , def: "{{request()->get('__key__password')}}"
                @endif
            },


            {


                label: " Matricule:", name: "matricule"
                @if(request()->has('__key__matricule'))
                , def: "{{request()->get('__key__matricule')}}"
                @endif
            },


            {


                label: " Emp_code:", name: "emp_code"
                @if(request()->has('__key__emp_code'))
                , def: "{{request()->get('__key__emp_code')}}"
                @endif
            },


            {


                label: " Nom:", name: "nom"
                @if(request()->has('__key__nom'))
                , def: "{{request()->get('__key__nom')}}"
                @endif
            },


            {


                label: " Prenom:", name: "prenom"
                @if(request()->has('__key__prenom'))
                , def: "{{request()->get('__key__prenom')}}"
                @endif
            },


            {


                label: " Num_badge:", name: "num_badge"
                @if(request()->has('__key__num_badge'))
                , def: "{{request()->get('__key__num_badge')}}"
                @endif
            },


            {


                label: " Date_naissance:", name: "date_naissance"
                @if(request()->has('__key__date_naissance'))
                , def: "{{request()->get('__key__date_naissance')}}"
                @endif
            },


            {


                label: " Num_cnss:", name: "num_cnss"
                @if(request()->has('__key__num_cnss'))
                , def: "{{request()->get('__key__num_cnss')}}"
                @endif
            },


            {


                label: " Num_cnamgs:", name: "num_cnamgs"
                @if(request()->has('__key__num_cnamgs'))
                , def: "{{request()->get('__key__num_cnamgs')}}"
                @endif
            },


            {


                label: " Telephone1:", name: "telephone1"
                @if(request()->has('__key__telephone1'))
                , def: "{{request()->get('__key__telephone1')}}"
                @endif
            },


            {


                label: " Telephone2:", name: "telephone2"
                @if(request()->has('__key__telephone2'))
                , def: "{{request()->get('__key__telephone2')}}"
                @endif
            },


            {


                label: " Nationalite:", name: "nationalite"
                @if(request()->has('__key__nationalite'))
                , def: "{{request()->get('__key__nationalite')}}"
                @endif
            },


            {


                label: " Nombre_enfant:", name: "nombre_enfant"
                @if(request()->has('__key__nombre_enfant'))
                , def: "{{request()->get('__key__nombre_enfant')}}"
                @endif
            },


            {


                label: " Photo:", name: "photo"
                @if(request()->has('__key__photo'))
                , def: "{{request()->get('__key__photo')}}"
                @endif
            },


            {


                label: " Actif:", name: "actif"
                @if(request()->has('__key__actif'))
                , def: "{{request()->get('__key__actif')}}"
                @endif
            },


            {


                label: " En_ligne:", name: "en_ligne"
                @if(request()->has('__key__en_ligne'))
                , def: "{{request()->get('__key__en_ligne')}}"
                @endif
            },


            {


                label: " Date_embauche:", name: "date_embauche"
                @if(request()->has('__key__date_embauche'))
                , def: "{{request()->get('__key__date_embauche')}}"
                @endif
            },


            {


                label: " Sexe:", name: "sexe"
                @if(request()->has('__key__sexe'))
                , def: "{{request()->get('__key__sexe')}}"
                @endif
            },


            {


                label: " Type:", name: "type"
                @if(request()->has('__key__type'))
                , def: "{{request()->get('__key__type')}}"
                @endif
            },


            {


                label: " Situation:", name: "situation"
                @if(request()->has('__key__situation'))
                , def: "{{request()->get('__key__situation')}}"
                @endif
            },


            {


                label: " Situation_matri:", name: "situation_matri"
                @if(request()->has('__key__situation_matri'))
                , def: "{{request()->get('__key__situation_matri')}}"
                @endif
            },


                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="fonction_id"   )


            {


                label: "Fonctions:",
                name: "fonction_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Fonctions:", name: "fonction_id", type: "select1", entite: 'fonctions'
            },

                @endif
                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="user_id"   )


            {


                label: "Users:",
                name: "user_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Users:", name: "user_id", type: "select1", entite: 'users'
            },

            @endif







        ];
        let fieldUsersConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Users_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Users_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Users_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Users_{{$__internalId__}}_customForm_general',
            display: Users_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldUsers,
        };

        fieldUsersConfig = $.extend(fieldUsersConfig, config)

        function Users_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Users_general_editor = new $.fn.dataTable.Editor(fieldUsersConfig);
        return Users_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Ventilations_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Ventilations_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Ventilations_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Ventilations_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Mois:", name: "mois"

            },


            {


                label: " Total:", name: "total"

            },


            {


                label: " Statut:", name: "statut", def: '0', type: 'hidden'
            },


            {
                label: "Users:", name: "user_id", type: "select1", entite: 'users'
            },


        ]
        ,
    };
    let Config_Ventilations_childs = [
        "ventilationsdetails",

    ]


    let Config_Ventilations_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Ventilations_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'mois'
            },


            {
                data: 'user_id'
            },


            {
                data: 'total'
            },


        ],
    };
    All_Table["ventilations"] = Config_Ventilations_table_{{$__internalId__}}
        All_Editor["ventilations"] = Config_Ventilations_editor_{{$__internalId__}}
        All_Child["ventilations"] = Config_Ventilations_childs


    function VentilationsGeneralEditor(position, config, Functions) {

        let fieldVentilations = [


            {


                label: " Mois:", name: "mois"
                @if(request()->has('__key__mois'))
                , def: "{{request()->get('__key__mois')}}"
                @endif
            },


            {


                label: " Total:", name: "total"
                @if(request()->has('__key__total'))
                , def: "{{request()->get('__key__total')}}"
                @endif
            },


            {


                label: " Statut:", name: "statut", def: '0', type: 'hidden'
            },


                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="user_id"   )


            {


                label: "Users:",
                name: "user_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Users:", name: "user_id", type: "select1", entite: 'users'
            },

            @endif







        ];
        let fieldVentilationsConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Ventilations_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Ventilations_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Ventilations_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Ventilations_{{$__internalId__}}_customForm_general',
            display: Ventilations_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldVentilations,
        };

        fieldVentilationsConfig = $.extend(fieldVentilationsConfig, config)

        function Ventilations_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Ventilations_general_editor = new $.fn.dataTable.Editor(fieldVentilationsConfig);
        return Ventilations_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Ventilationsdetails_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Ventilationsdetails_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Ventilationsdetails_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Ventilationsdetails_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Semaine:", name: "semaine"

            },


            {


                label: " Dimanche:", name: "dimanche"

            },


            {


                label: " Lundi:", name: "lundi"

            },


            {


                label: " Mardi:", name: "mardi"

            },


            {


                label: " Mercredi:", name: "mercredi"

            },


            {


                label: " Jeudi:", name: "jeudi"

            },


            {


                label: " Vendredi:", name: "vendredi"

            },


            {


                label: " Samedi:", name: "samedi"

            },


            {


                label: " Hn:", name: "hn"

            },


            {


                label: " Hs15:", name: "hs15"

            },


            {


                label: " Hs26:", name: "hs26"

            },


            {


                label: " Hs55:", name: "hs55"

            },


            {


                label: " Hs30:", name: "hs30"

            },


            {


                label: " Hs60:", name: "hs60"

            },


            {


                label: " Hs115:", name: "hs115"

            },


            {


                label: " Hs130:", name: "hs130"

            },


            {


                label: " Total:", name: "total"

            },


            {
                label: "Users:", name: "user_id", type: "select1", entite: 'users'
            },


            {
                label: "Ventilations:", name: "ventilation_id", type: "select1", entite: 'ventilations'
            },


        ]
        ,
    };
    let Config_Ventilationsdetails_childs = []


    let Config_Ventilationsdetails_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Ventilationsdetails_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'ventilation_id'
            },


            {
                data: 'user_id'
            },


            {
                data: 'semaine'
            },


            {
                data: 'dimanche'
            },


            {
                data: 'lundi'
            },


            {
                data: 'mardi'
            },


            {
                data: 'mercredi'
            },


            {
                data: 'jeudi'
            },


            {
                data: 'vendredi'
            },


            {
                data: 'samedi'
            },


            {
                data: 'hn'
            },


            {
                data: 'hs15'
            },


            {
                data: 'hs26'
            },


            {
                data: 'hs55'
            },


            {
                data: 'hs30'
            },


            {
                data: 'hs60'
            },


            {
                data: 'hs115'
            },


            {
                data: 'hs130'
            },


            {
                data: 'total'
            },


        ],
    };
    All_Table["ventilationsdetails"] = Config_Ventilationsdetails_table_{{$__internalId__}}
        All_Editor["ventilationsdetails"] = Config_Ventilationsdetails_editor_{{$__internalId__}}
        All_Child["ventilationsdetails"] = Config_Ventilationsdetails_childs


    function VentilationsdetailsGeneralEditor(position, config, Functions) {

        let fieldVentilationsdetails = [


            {


                label: " Semaine:", name: "semaine"
                @if(request()->has('__key__semaine'))
                , def: "{{request()->get('__key__semaine')}}"
                @endif
            },


            {


                label: " Dimanche:", name: "dimanche"
                @if(request()->has('__key__dimanche'))
                , def: "{{request()->get('__key__dimanche')}}"
                @endif
            },


            {


                label: " Lundi:", name: "lundi"
                @if(request()->has('__key__lundi'))
                , def: "{{request()->get('__key__lundi')}}"
                @endif
            },


            {


                label: " Mardi:", name: "mardi"
                @if(request()->has('__key__mardi'))
                , def: "{{request()->get('__key__mardi')}}"
                @endif
            },


            {


                label: " Mercredi:", name: "mercredi"
                @if(request()->has('__key__mercredi'))
                , def: "{{request()->get('__key__mercredi')}}"
                @endif
            },


            {


                label: " Jeudi:", name: "jeudi"
                @if(request()->has('__key__jeudi'))
                , def: "{{request()->get('__key__jeudi')}}"
                @endif
            },


            {


                label: " Vendredi:", name: "vendredi"
                @if(request()->has('__key__vendredi'))
                , def: "{{request()->get('__key__vendredi')}}"
                @endif
            },


            {


                label: " Samedi:", name: "samedi"
                @if(request()->has('__key__samedi'))
                , def: "{{request()->get('__key__samedi')}}"
                @endif
            },


            {


                label: " Hn:", name: "hn"
                @if(request()->has('__key__hn'))
                , def: "{{request()->get('__key__hn')}}"
                @endif
            },


            {


                label: " Hs15:", name: "hs15"
                @if(request()->has('__key__hs15'))
                , def: "{{request()->get('__key__hs15')}}"
                @endif
            },


            {


                label: " Hs26:", name: "hs26"
                @if(request()->has('__key__hs26'))
                , def: "{{request()->get('__key__hs26')}}"
                @endif
            },


            {


                label: " Hs55:", name: "hs55"
                @if(request()->has('__key__hs55'))
                , def: "{{request()->get('__key__hs55')}}"
                @endif
            },


            {


                label: " Hs30:", name: "hs30"
                @if(request()->has('__key__hs30'))
                , def: "{{request()->get('__key__hs30')}}"
                @endif
            },


            {


                label: " Hs60:", name: "hs60"
                @if(request()->has('__key__hs60'))
                , def: "{{request()->get('__key__hs60')}}"
                @endif
            },


            {


                label: " Hs115:", name: "hs115"
                @if(request()->has('__key__hs115'))
                , def: "{{request()->get('__key__hs115')}}"
                @endif
            },


            {


                label: " Hs130:", name: "hs130"
                @if(request()->has('__key__hs130'))
                , def: "{{request()->get('__key__hs130')}}"
                @endif
            },


            {


                label: " Total:", name: "total"
                @if(request()->has('__key__total'))
                , def: "{{request()->get('__key__total')}}"
                @endif
            },


                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="user_id"   )


            {


                label: "Users:",
                name: "user_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Users:", name: "user_id", type: "select1", entite: 'users'
            },

                @endif
                @if(request()->get('pkey') && request()->get('pval')  && request()->get('pkey')=="ventilation_id"   )


            {


                label: "Ventilations:",
                name: "ventilation_id",
                def: "{{request()->get('pval')}}",
                type: "hidden"
            },
                @else
            {
                label: "Ventilations:", name: "ventilation_id", type: "select1", entite: 'ventilations'
            },

            @endif







        ];
        let fieldVentilationsdetailsConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Ventilationsdetails_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Ventilationsdetails_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Ventilationsdetails_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Ventilationsdetails_{{$__internalId__}}_customForm_general',
            display: Ventilationsdetails_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldVentilationsdetails,
        };

        fieldVentilationsdetailsConfig = $.extend(fieldVentilationsdetailsConfig, config)

        function Ventilationsdetails_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Ventilationsdetails_general_editor = new $.fn.dataTable.Editor(fieldVentilationsdetailsConfig);
        return Ventilationsdetails_general_editor


    }

</script>


<script>
    import CustomSelect from "@/components/CustomSelect.vue";

    let Config_Villes_editor_{{$__internalId__}}= {

        ajax: {
            create: {
                type: 'POST',
                url: "{{ URL::signedRoute('Villes_web_create') }}"
            },
            edit: {
                type: 'POST',
                url: "{{route('Villes_web_index')}}/_id_/update",
            },

            remove: {
                type: 'POST',
                url: "{{route('Villes_web_index')}}/_id_/delete"
            },
            cache: true

        },

        fields: [


            {


                label: " Libelle:", name: "libelle"

            },


        ]
        ,
    };
    let Config_Villes_childs = [
        "taches",

    ]


    let Config_Villes_table_{{$__internalId__}}= {


        ajax: {
            url: "{{ route('Villes_web_index')}}_data",
            type: 'POST',
            cache: true

        },

        searchHighlight: true,
        language: {
            search: 'Chercher:',
            zeroRecords: 'aucun resultats',
            sSearchPlaceholder: 'Entrez votre recherche',
        },
        fixedHeader: true,
        lengthMenu: [[10, 50, 100], [10, 50, 100]],
        colReorder: {
            realtime: false,
        },
        dom: 'lBtip',
        responsive: true,
        buttons: [],
        columns: [
            {
                data: null
            },


            {
                data: 'libelle'
            },


        ],
    };
    All_Table["villes"] = Config_Villes_table_{{$__internalId__}}
        All_Editor["villes"] = Config_Villes_editor_{{$__internalId__}}
        All_Child["villes"] = Config_Villes_childs


    function VillesGeneralEditor(position, config, Functions) {

        let fieldVilles = [


            {


                label: " Libelle:", name: "libelle"
                @if(request()->has('__key__libelle'))
                , def: "{{request()->get('__key__libelle')}}"
                @endif
            },


        ];
        let fieldVillesConfig = {

            ajax: {
                create: {
                    type: 'POST',
                    url: "{{ URL::signedRoute('Villes_web_create') }}"
                },
                edit: {
                    type: 'POST',
                    url: "{{route('Villes_web_index')}}/_id_/update",
                },

                remove: {
                    type: 'POST',
                    url: "{{route('Villes_web_index')}}/_id_/delete"
                },
                cache: true

            },

            template: '#Villes_{{$__internalId__}}_customForm_general',
            display: Villes_onPageDisplay_{{$__internalId__}}($(position)),
            fields: fieldVilles,
        };

        fieldVillesConfig = $.extend(fieldVillesConfig, config)

        function Villes_onPageDisplay_{{$__internalId__}}(elm) {
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


        let Villes_general_editor = new $.fn.dataTable.Editor(fieldVillesConfig);
        return Villes_general_editor


    }

</script>







