<template>
    <b-overlay :show="isLoading">


        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div>Ajouter des agents a la liste</div>
            </template>

            <AgGridSearch
                :columnDefs="add.columnDefs"
                :extrasData="add.extrasData"
                :filterFields="['nom','prenom','matricule']"
                :url="add.url"
                filter-key="type_id"
                filter-value="2"
                @destruction="finishAddUser"
            >
            </AgGridSearch>


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>

        <div v-if="isCloturer()" class="d-flex justify-content-around" style="margin: 10px">
            <button class="btn btn-warning" disabled type="button">
                <i class="fa-solid fa-lock"></i> Listing cloturer plus aucune modification possible
            </button>
        </div>
        <form @submit.prevent="EditLine()">
            <div class="mb-3">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>libelle </label>
                        <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.libelle" class="invalid-feedback">
                            <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>date </label>
                        <input v-model="form.date" :class="errors.date?'form-control is-invalid':'form-control'"
                               disabled
                               type="date">

                        <div v-if="errors.date" class="invalid-feedback">
                            <template v-for=" error in errors.date"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6" style="cursor:pointer" @click="selectAbscent()">
                        <statistic-card-horizontal
                            :statistic="abscent"
                            background="#00cfe8"
                            color="success"
                            icon="UsersIcon"
                            iconColor="#fff"
                            statistic-title="Abscent"
                        />
                    </div>
                    <div class="col-sm-6" style="cursor:pointer" @click="selectPresent()">
                        <statistic-card-horizontal
                            :statistic="present"
                            background="rgb(255, 159, 67)"
                            color="success"
                            icon="UsersIcon"
                            iconColor="#fff"
                            statistic-title="Present"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">

                        <button v-if="filterOnlyAbscent" class="btn btn-danger" style="width:100%">Listes des abscent
                        </button>
                        <button v-if="filterOnlyPresent" class="btn btn-success" style="width:100%">Listes des present
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <AgGridTable
                            :key="tableKey"
                            :cacheBlockSize="cacheBlockSize"
                            :columnDefs="columnDefs"
                            :extrasData="extrasData"
                            :maxBlocksInCache="maxBlocksInCache"
                            :pagination="pagination"
                            :paginationPageSize="paginationPageSize"
                            :rowData="rowData"
                            :rowModelType="rowModelType"
                            :show-export="false"
                            :show-pagination="false"
                            :url="url"
                            className="ag-theme-alpine"
                            dom-layout="normal"
                            domLayout='autoHeight'
                            rowSelection="multiple"
                            @gridReady="onGridReady"

                        >

                            <template v-if="isAutomatique()" #header_buttons>
                                <div v-if="!isCloturer()" class="btn btn-primary" @click="openCreate"><i
                                    class="fa fa-plus"></i> Ajouter des agents
                                </div>
                            </template>
                        </AgGridTable>

                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button v-if="!isCloturer()" class="btn btn-warning" type="button" @click.prevent="Cloturer()">
                    <i class="fa-solid fa-lock"></i> Valider et cloturer
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Archiver
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

import AgGridTable from "@/components/AgGridTable.vue"
import AgGridSearch from "@/components/AgGridSearch.vue";
import ListingsTraitements from "@/views/content/Listings/ListingsTraitements.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import StatisticCardVertical from "@core/components/statistics-cards/StatisticCardVertical.vue";
import StatisticCardHorizontal from "@core/components/statistics-cards/StatisticCardHorizontal.vue";
import StatisticCardWithAreaChart from "@core/components/statistics-cards/StatisticCardWithAreaChart.vue";
import StatisticCardWithLineChart from "@core/components/statistics-cards/StatisticCardWithLineChart.vue";


export default {
    name: 'EditListingsjours',
    components: {
        VSelect,
        CustomSelect,
        Files,
        AgGridBtnClicked,
        ListingsTraitements,
        AgGridTable,
        AgGridSearch,
        StatisticCardVertical,
        StatisticCardHorizontal,
        StatisticCardWithAreaChart,
        StatisticCardWithLineChart
    },
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },

        extrasData: function () {
            let params = {baseFilter: {}}
            params['baseFilter']['id_date'] = {values: [this.data.id], filterType: 'set'}
            if (this.filterOnlyPresent) {
                params['baseFilter']['present'] = {values: ['oui'], filterType: 'set'}
            }
            if (this.filterOnlyAbscent) {
                params['baseFilter']['present'] = {values: ['non'], filterType: 'set'}
            }
            return params


        }
    },
    props: ['data', 'gridApi', 'modalFormId',
        'actifsData',
        'balisesData',
        'categoriesData',
        'contratsData',
        'directionsData',
        'echelonsData',
        'factionsData',
        'fonctionsData',
        'matrimonialesData',
        'nationalitesData',
        'onlinesData',
        'postesData',
        'sexesData',
        'sitesData',
        'situationsData',
        'typesData',
        'usersData',
        'villesData',
        'zonesData',
    ],

    watch: {
        'extrasData': {
            handler: function (after, before) {
                this.tableKey++

            },
            deep: true
        },
    },
    data() {
        return {
            errors: [],
            userAdded: 0,
            isLoading: false,
            filterOnlyPresent: false,
            filterOnlyAbscent: false,
            abscent: 0,
            present: 0,
            form: {

                id: "",

                libelle: "",

                date: "",
                etats: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            },
            formId: "listings",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/listings-Aggrid',
            table: 'listings',
            requette: 18,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            add: {
                formId: "listings",
                formState: "",
                formData: {},
                formWidth: 'lg',
                formGridApi: {},
                formKey: 0,
                tableKey: 0,
                url: 'http://127.0.0.1:8000/api/listings-Aggrid',
                table: 'Users',
                requette: 18,
                columnDefs: null,
                rowData: null,
                gridApi: null,
                columnApi: null,
                rowModelType: null,
                pagination: true,
                paginationPageSize: 100,
                cacheBlockSize: 10,
                maxBlocksInCache: 1,
                extrasData: {},
            }
        }
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/listings-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;


        this.add.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
            this.add.rowBuffer = 0;
        this.add.rowModelType = 'serverSide';
        this.add.cacheBlockSize = 50;
        this.add.maxBlocksInCache = 2;
        // let params = {}
        // params['id_date'] = {values: [this.data.id], filterType: 'set'}
        // this.extrasData['baseFilter'] = params


    },
    beforeMount() {


    },
    mounted() {
        this.form = this.data
        this.form['date'] = this.form['date'].split(' ')[0]
        this.columnDefs = [
            // {
            //   field: null,
            //   headerName: '',
            //   suppressCellSelection: true,
            //   minWidth: 80,maxWidth: 80,
            //   pinned: 'left',
            //   cellRendererSelector: params => {
            //     return {
            //       component: 'AgGridBtnClicked',
            //       params: {
            //         clicked: field => {
            //           this.showForm('Update', field, params.api)
            //         },
            //         render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

            //       }
            //     };
            //   },
            //
            // },


            // {
            //   field: "name",
            //   sortable: true,
            //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            //   headerName: 'name',
            // },
            // hide: true,
            //   suppressColumnsToolPanel: true,
            {
                field: null,

                minWidth: 80, maxWidth: 80,
                pinned: 'left',
                hide: !this.isAutomatique(),
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: '',
                cellRendererSelector: params => {
                    let response = {
                        component: 'AgGridBtnClicked',
                        params: {
                            clicked: field => {
                                this.deleteUser(field)
                            },
                            render: `<button class="btn btn-warning" > <i class="fa-solid fa-trash "></i></button>`
                        }
                    }
                    if (this.isCloturer()) {
                        response.params.render = `<button class="btn btn-warning" disabled > <i class="fa-solid fa-trash "> </i></button>`
                        response.params.clicked = () => {
                        }
                    }
                    return response;
                },
            },
            {
                field: "date",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'date',
                valueFormatter: params => {
                    let retour = params.value
                    try {
                        retour = params.value.split(' ')[0]
                    } catch (e) {

                    }
                    return retour
                }
            },

            {
                field: "matricule",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'matricule',
            },
            {
                field: "nom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'nom',
            },
            {
                field: "prenom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'prenom',
            },
            {
                field: "present",
                suppressColumnsToolPanel: true,
                headerName: 'present',
                cellRendererSelector: params => {
                    return {
                        component: 'ListingsTraitements',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            etats: this.form.etats
                        }
                    };
                },
            },
            {

                headerName: 'fonction',
                field: 'fonction_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['fonction']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.fonctionsData);
                    },
                    refreshValuesOnOpen: true,
                },
            },
            {
                field: "num_badge",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'num_badge',
            },


            // {
            //   field: "emp_code",
            //   sortable: true,
            //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            //   headerName: 'emp_code',
            // },


            //
            // {
            //   field: "id_date",
            //   sortable: true,
            //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            //   headerName: 'id_date',
            // },


            // {
            //
            //   headerName: 'actif',
            //   field: 'actif_id',
            //   valueFormatter: params => {
            //     let retour = ''
            //     try {
            //       return params.data['actif']['Selectlabel']
            //     } catch (e) {
            //
            //     }
            //     return retour
            //   },
            //
            //   filter: 'agSetColumnFilter',
            //   filterParams: {suppressAndOrCondition: true,
            //     keyCreator: params => params.value.id,
            //     valueFormatter: params => params.value.Selectlabel,
            //     values: params => {
            //       params.success(this.actifsData);
            //     },
            //     refreshValuesOnOpen: true,
            //   },
            // },


            // {
            //
            //   headerName: 'balise',
            //   field: 'balise_id',
            //   valueFormatter: params => {
            //     let retour = ''
            //     try {
            //       return params.data['balise']['Selectlabel']
            //     } catch (e) {
            //
            //     }
            //     return retour
            //   },
            //
            //   filter: 'agSetColumnFilter',
            //   filterParams: {suppressAndOrCondition: true,
            //     keyCreator: params => params.value.id,
            //     valueFormatter: params => params.value.Selectlabel,
            //     values: params => {
            //       params.success(this.balisesData);
            //     },
            //     refreshValuesOnOpen: true,
            //   },
            // },


            // {
            //
            //   headerName: 'categorie',
            //   field: 'categorie_id',
            //   valueFormatter: params => {
            //     let retour = ''
            //     try {
            //       return params.data['categorie']['Selectlabel']
            //     } catch (e) {
            //
            //     }
            //     return retour
            //   },
            //
            //   filter: 'agSetColumnFilter',
            //   filterParams: {suppressAndOrCondition: true,
            //     keyCreator: params => params.value.id,
            //     valueFormatter: params => params.value.Selectlabel,
            //     values: params => {
            //       params.success(this.categoriesData);
            //     },
            //     refreshValuesOnOpen: true,
            //   },
            // },
            //
            //
            // {
            //
            //   headerName: 'contrat',
            //   field: 'contrat_id',
            //   valueFormatter: params => {
            //     let retour = ''
            //     try {
            //       return params.data['contrat']['Selectlabel']
            //     } catch (e) {
            //
            //     }
            //     return retour
            //   },
            //
            //   filter: 'agSetColumnFilter',
            //   filterParams: {suppressAndOrCondition: true,
            //     keyCreator: params => params.value.id,
            //     valueFormatter: params => params.value.Selectlabel,
            //     values: params => {
            //       params.success(this.contratsData);
            //     },
            //     refreshValuesOnOpen: true,
            //   },
            // },


            {

                headerName: 'direction',
                field: 'direction_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['direction']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.directionsData);
                    },
                    refreshValuesOnOpen: true,
                },
            },


            {

                headerName: 'echelon',
                field: 'echelon_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['echelon']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.echelonsData);
                    },
                    refreshValuesOnOpen: true,
                },
            },


            {

                headerName: 'faction',
                field: 'faction_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['faction']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.factionsData);
                    },
                    refreshValuesOnOpen: true,
                },
            },


            // {
            //
            //   headerName: 'matrimoniale',
            //   field: 'matrimoniale_id',
            //   valueFormatter: params => {
            //     let retour = ''
            //     try {
            //       return params.data['matrimoniale']['Selectlabel']
            //     } catch (e) {
            //
            //     }
            //     return retour
            //   },
            //
            //   filter: 'agSetColumnFilter',
            //   filterParams: {suppressAndOrCondition: true,
            //     keyCreator: params => params.value.id,
            //     valueFormatter: params => params.value.Selectlabel,
            //     values: params => {
            //       params.success(this.matrimonialesData);
            //     },
            //     refreshValuesOnOpen: true,
            //   },
            // },


            {

                headerName: 'nationalite',
                field: 'nationalite_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['nationalite']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.nationalitesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },


            // {
            //
            //   headerName: 'online',
            //   field: 'online_id',
            //   valueFormatter: params => {
            //     let retour = ''
            //     try {
            //       return params.data['online']['Selectlabel']
            //     } catch (e) {
            //
            //     }
            //     return retour
            //   },
            //
            //   filter: 'agSetColumnFilter',
            //   filterParams: {suppressAndOrCondition: true,
            //     keyCreator: params => params.value.id,
            //     valueFormatter: params => params.value.Selectlabel,
            //     values: params => {
            //       params.success(this.onlinesData);
            //     },
            //     refreshValuesOnOpen: true,
            //   },
            // },


            {

                headerName: 'poste',
                field: 'poste_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['poste']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.postesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },


            {

                headerName: 'sexe',
                field: 'sexe_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['sexe']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.sexesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },


            {

                headerName: 'site',
                field: 'site_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['site']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.sitesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },


            {

                headerName: 'situation',
                field: 'situation_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['situation']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.situationsData);
                    },
                    refreshValuesOnOpen: true,
                },
            },


            // {
            //
            //   headerName: 'type',
            //   field: 'type_id',
            //   valueFormatter: params => {
            //     let retour = ''
            //     try {
            //       return params.data['type']['Selectlabel']
            //     } catch (e) {
            //
            //     }
            //     return retour
            //   },
            //
            //   filter: 'agSetColumnFilter',
            //   filterParams: {suppressAndOrCondition: true,
            //     keyCreator: params => params.value.id,
            //     valueFormatter: params => params.value.Selectlabel,
            //     values: params => {
            //       params.success(this.typesData);
            //     },
            //     refreshValuesOnOpen: true,
            //   },
            // },


            {

                headerName: 'ville',
                field: 'ville_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['ville']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.villesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },


            {

                headerName: 'zone',
                field: 'zone_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['zone']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: 'agSetColumnFilter',
                filterParams: {
                    suppressAndOrCondition: true,
                    keyCreator: params => params.value.id,
                    valueFormatter: params => params.value.Selectlabel,
                    values: params => {
                        params.success(this.zonesData);
                    },
                    refreshValuesOnOpen: true,
                },
            },

        ];
        this.add.columnDefs = [

            {
                field: null,

                width: 100,
                pinned: 'left',
                hide: !this.isAutomatique(),
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: '',
                cellRendererSelector: params => {
                    let response = {
                        component: 'AgGridBtnClicked',
                        params: {
                            clicked: field => {
                                this.addUser(field)
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                        }
                    }
                    if (this.isCloturer()) {
                        response.params.render = `<button class="btn btn-success" disabled > <i class="fa-solid fa-square-plus"></i></button>`
                        response.params.clicked = () => {
                        }
                    }
                    return response;
                },
            },
            {
                field: "matricule",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'matricule',
            },
            {
                field: "nom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'nom',
            },
            {
                field: "prenom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'prenom',
            },
            {
                field: "num_badge",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'num_badge',
            },


        ];
        // this.getStats();

    },
    methods: {
        selectAbscent() {
            this.filterOnlyPresent = false;
            this.filterOnlyAbscent = !this.filterOnlyAbscent
        },
        selectPresent() {

            this.filterOnlyAbscent = false;
            this.filterOnlyPresent = !this.filterOnlyPresent
        },
        finishAddUser() {
            // evenement appeler lorsquon ferme le formulaire dajout des agents
            // on verifie si on ajouter des agents et on met a jour le tableau sinon on ne fait rien
            if (this.userAdded > 0) {
                this.tableKey++
            }
            this.userAdded = 0
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },

        showForm(type, data, gridApi, width = 'lg') {
            this.formKey++
            this.formWidth = width
            this.formState = type
            this.formData = data
            this.formGridApi = gridApi
            this.$bvModal.show(this.formId)
        },
        deleteUser(element) {
            this.isLoading = true
            let data = {}
            data.id = element.id
            // this.axios.post('/api/listingsetats/action?action=deleteUser', data).then(response => {
            this.axios.post('/api/listingsetatsActionDeleteUser', data).then(response => {
                this.isLoading = false
                this.tableKey++
                // this.gridApi.applyServerSideTransaction({
                //   remove: [
                //     element.id
                //   ],
                // });
                this.$toast.success('Operation effectuer avec succes')
            }).catch(error => {
                console.log('error lors de la suppression des users ==>', error)
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        addUser(element) {
            this.isLoading = true
            let data = {}
            data.user_id = element.id
            data.listingsjour_id = this.form.id
            this.axios.post('/api/listingsetatsActionAddUser', data).then(response => {
                // this.axios.post('/api/listingsetats/action?action=addUser', data).then(response => {
                this.isLoading = false
                this.$toast.success('Operation effectuer avec succes')
                this.userAdded++
            }).catch(error => {
                console.log('error lors de la suppression des users ==>', error)
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        onGridReady(params) {
            console.log('on demarre', params)
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false
        },

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/listingsjours/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        Cloturer() {
            this.isLoading = true
            this.form.etats = this.form.etats + '-cloturer'
            this.axios.post('/api/listingsjours/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/listingsjours/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        isCloturer() {
            return this.form.etats == 'manuel-cloturer' || this.form.etats == 'automatique-cloturer'
        },
        canAdmin() {
            // function appeler pur verifier si on peut oui ou non rajouter et supprimer des element
            return this.form.etats == 'automatique'
        },
        isAutomatique() {
            // function appeler pur verifier si on peut oui ou non rajouter et supprimer des element
            return this.form.etats == 'automatique' || this.form.etats == 'automatique-cloturer'
        },
        getStats() {
            this.isLoading = true
            this.axios.post('/api/listingsjoursActionGetStats', this.form).then(response => {
                // this.axios.post('/api/listingsjours/action?action=getStats', this.form).then(response => {
                this.isLoading = false
                this.abscent = response.data.abscent
                this.present = response.data.present
                console.log(response.data)
            }).catch(error => {
                this.isLoading = false
            })
        }
    }
}
</script>
