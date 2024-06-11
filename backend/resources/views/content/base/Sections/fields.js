let field = [
    {label: "Components:", name: "component_id", type: "select1", entite: 'components', class: 'col-sm-12 order-01'},
    {label: " name :", name: "name", class: 'col-sm-6 order-02'},
    {label: " taille :", name: "width", class: 'col-sm-6 order-02'},
    {label: " taille :", name: "dataComponents", class: 'col-sm-6 order-02'},

    {
        label: "Css  :",
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

    },
    {
        label: " Media_query  :", name: "media_query",
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

    }
]


let fields = [
    {
        label: "Elements",
        name: "elements",
        type: "repeat",
        champs: [],
        render: function (data) {
            return data.name
        },
        after: function (editor, datatable) {
            editor.dependent('component_id', function (val) {
                let retour = {}
                if (val.length > 0) {
                    let urlBase = '{{route('
                    Components_web_index
                    ')}}' + '_data/id/' + val[0]
                    $.ajax({
                        url: urlBase,
                        dataType: 'json'
                    })
                        .done(function (data) {
                            if (data.data && data.data.length > 0) {
                                let donnees = data.data[0]
                                let structures = JSON.parse(data.data[0].structures)
                                let i = 15
                                structures = structures.map(dat => {

                                    dat.class = "col-sm-12 order-" + i
                                    i++
                                    return dat
                                })
                                let champsSuppimer = editor.order().filter(data => {
                                    let base = [
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
                                editor.clear(champsSuppimer)
                                champsSuppimer.forEach(data => {
                                    let oldTemplate = editor.template()
                                    oldTemplate.find('.card-body').find('.row').find(`[data-editor-template="${data}"]`).remove()

                                })

                                let newId = "Text_" + "" + Date.now()
                                let form = $(`<div id='form_${newId}' style="display:none"></div>`)
                                structures.forEach(data => {
                                    let oldTemplate = editor.template()
                                    let classe = 'col-sm-12 order-99'
                                    if (data.class) {
                                        classe = data.class

                                    }
                                    let el = $(` <div class='${classe}' data-editor-template='${data.name}'></div>`)
                                    oldTemplate.find('.card-body').find('.row').find('[data-editor-template="css"]').before(el)
                                })

                                editor.add(structures)


                                console.log("voici les donnees:", donnees, structures,);

                            }


                        });

                } else {
                    let champsSuppimer = editor.order().filter(data => {
                        let base = [
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
                    editor.clear(champsSuppimer)
                    champsSuppimer.forEach(data => {
                        let oldTemplate = editor.template()
                        oldTemplate.find('.card-body').find('.row').find(`[data-editor-template="${data}"]`).remove()

                    })

                }


                return retour
            })
            datatable.on('draw', function () {
                console.log('il ya eu un draw et voici les donnees', datatable.data().toArray())
            })
        }
    },

]
