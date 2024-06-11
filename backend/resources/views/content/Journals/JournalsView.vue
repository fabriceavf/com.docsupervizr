<template>
    <div>

        <form @submit.prevent="checkInDate()">

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>date de debut </label>
                        <input v-model="form.debut" class="form-control" required type="datetime-local">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>date de fin </label>
                        <input v-model="form.fin" class="form-control" required type="datetime-local">

                    </div>
                </div>

                <!-- <div class="col-sm-2">
                    <div class="form-group">
                        </br>
                        <button class="btn btn-primary" type="submit">Valider</button>

                    </div>
                </div> -->


            </div>
        </form>

        <div :key="key" class="row">
            <b-modal :id="formId" :size="formWidth">
                <template #modal-title>
                    <div v-if="formState == 'Update'">Update Journals #{{ formData.id }}</div>
                    <div v-if="formState == 'Create'">Create Journals</div>
                    <div v-if="formState == 'CreateRapport'">Generer un rapport</div>
                    <div v-if="formState == 'DetailTaches'">Listes des taches associer au pointages en fonction de la
                        pointeuse
                    </div>
                    <div v-if="formState == 'DetailPostes'">Listes des postes associer au pointages en fonction de la
                        pointeuse
                    </div>
                </template>


                <EditJournals v-if="formState == 'Update'" :key="formKey" :actifsData="actifsData"
                              :balisesData="balisesData" :categoriesData="categoriesData" :contratsData="contratsData"
                              :data="formData" :directionsData="directionsData" :echelonsData="echelonsData"
                              :factionsData="factionsData" :fonctionsData="fonctionsData" :gridApi="formGridApi"
                              :matrimonialesData="matrimonialesData" :modalFormId="formId"
                              :nationalitesData="nationalitesData"
                              :onlinesData="onlinesData" :pointeusesData="pointeusesData" :postesData="postesData"
                              :sexesData="sexesData" :sitesData="sitesData" :situationsData="situationsData"
                              :typesData="typesData"
                              :villesData="villesData" :zonesData="zonesData" @close="closeForm"/>

                <TachesView v-if="formState == 'DetailTaches'" :data="formData">

                </TachesView>
                <PostesView v-if="formState == 'DetailPostes'" :data="formData">

                </PostesView>
                <CreateJournals v-if="formState == 'Create'" :key="formKey" :actifsData="actifsData"
                                :balisesData="balisesData" :categoriesData="categoriesData" :contratsData="contratsData"
                                :directionsData="directionsData" :echelonsData="echelonsData"
                                :factionsData="factionsData"
                                :fonctionsData="fonctionsData" :gridApi="formGridApi"
                                :matrimonialesData="matrimonialesData"
                                :modalFormId="formId" :nationalitesData="nationalitesData" :onlinesData="onlinesData"
                                :pointeusesData="pointeusesData" :postesData="postesData" :sexesData="sexesData"
                                :sitesData="sitesData"
                                :situationsData="situationsData" :typesData="typesData" :villesData="villesData"
                                :zonesData="zonesData"
                                @close="closeForm"/>

                <GetRapport v-if="formState == 'CreateRapport'" :key="formKey" :actifsData="actifsData"
                            :balisesData="balisesData" :categoriesData="categoriesData" :contratsData="contratsData"
                            :directionsData="directionsData" :echelonsData="echelonsData" :factionsData="factionsData"
                            :fonctionsData="fonctionsData" :gridApi="formGridApi" :matrimonialesData="matrimonialesData"
                            :modalFormId="formId" :nationalitesData="nationalitesData" :onlinesData="onlinesData"
                            :pointeusesData="pointeusesData" :postesData="postesData" :sexesData="sexesData"
                            :sitesData="sitesData"
                            :situationsData="situationsData" :typesData="typesData" :villesData="villesData"
                            :zonesData="zonesData"
                            @close="closeForm"/>

                <template #modal-footer>
                    <div></div>
                </template>
            </b-modal>


            <div class="col-sm-12">
                <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                             :extrasData="extrasData"
                             :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                             :paginationPageSize="paginationPageSize"
                             :rowData="rowData" :rowModelType="rowModelType" :url="url" className="ag-theme-alpine"
                             domLayout='autoHeight' rowSelection="multiple" @gridReady="onGridReady">
                    <template #header_buttons>
                        <div v-if="!$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                            class="fa fa-plus"></i>
                            Nouveau
                        </div>

                    </template>

                </AgGridTable>

            </div>
        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateJournals from './CreateJournals.vue'
import EditJournals from './EditJournals.vue'
import DataModal from '@/components/DataModal.vue'
import GetRapport from "./GetRapport.vue"
import TachesView from "./TachesView.vue"
import PostesView from "./PostesView.vue"
import CustomFiltre from "@/components/CustomFiltre.vue";
import moment from 'moment'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'JournalsView',
    components: {
        DataTable,
        AgGridTable,
        CreateJournals,
        EditJournals,
        DataModal,
        AgGridBtnClicked,
        GetRapport,
        TachesView,
        CustomFiltre,
        PostesView
    },
    data() {

        return {
            showFormElement: false,
            formId: "journals",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/journals-Aggrid',
            table: 'journals',
            actifsData: [],
            balisesData: [],
            directionsget: [],
            categoriesData: [],
            contratsData: [],
            directionsData: [],
            echelonsData: [],
            factionsData: [],
            directionselectionner: [],
            fonctionsData: [],
            matrimonialesData: [],
            nationalitesData: [],
            onlinesData: [],
            pointeusesData: [],
            postesData: [],
            tachesData: [],
            sexesData: [],
            sitesData: [],
            clientsData: [],
            situationsData: [],
            typesData: [],
            villesData: [],
            zonesData: [],
            requette: 19,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            key: 0,
            form: {
                debut: 0,
                fin: 0
            },
        }
    },

    computed: {
        $domaine: function () {
            let domaine = 'supervizr';
            try {
                domaine = window.domaine
            } catch (e) {
            }

            console.log('voila le domaine ==>', domaine)
            return domaine;
        },
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
        params: function () {
            let params = {};
            try {
                if (typeof window.params != 'undefined') {
                    params = window.params
                }
            } catch (e) {
            }
            return params;
        },
        taille: function () {
            let result = 'col-sm-12'
            if (this.filtre) {
                result = 'col-sm-9'
            }
            return result
        },
        extrasData: function () {
            let params = {};

            this.tableKey++;

            return {
                debut: this.form.debut,
                fin: this.form.fin,
                directionselectionner: this.directionselectionner,
            };

        },
    },
    watch: {
        '$route': {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null)
                this.gridApi.refreshServerSide()
                this.tableKey++
            },
            deep: true
        },
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/transactions-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

    },
    beforeMount() {

        this.columnDefs =
            [
                {
                    field: "id",
                    sortable: true,
                    filter: 'agTextColumnFilter',
                    filterParams: {suppressAndOrCondition: true,},
                    hide: true,
                    headerName: '#Id',
                },
                {
                    field: null,
                    headerName: '',
                    suppressCellSelection: true,
                    width: 80,
                    pinned: 'left',
                    cellRendererSelector: params => {
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },

                // {
                //     hide: true,
                //     suppressColumnsToolPanel: true,

                //     headerName: 'Agent',
                //     field: 'user_id',
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['user']['Selectlabel']
                //         } catch (e) {

                //         }
                //         return retour
                //     },
                //     filter: "CustomFiltre",
                //     filterParams: {
                //         url: this.axios.defaults.baseURL + '/api/users-Aggrid',
                //         columnDefs: [
                //             {
                //                 field: "",
                //                 sortable: true,
                //                 filter: "agTextColumnFilter",
                //                 filterParams: {suppressAndOrCondition: true},
                //                 headerName: "",
                //                 cellStyle: {fontSize: '11px'},
                //                 valueFormatter: (params) => {
                //                     let retour = "";
                //                     try {
                //                         return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
                //                     } catch (e) {
                //                     }
                //                     return retour;
                //                 },
                //             },
                //         ],
                //         filterFields: ['matricule', 'nom', 'prenom'],
                //     },
                // },

                {
                    field: "punch_time",
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Jour',
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
                    field: "punch_time",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Heure',
                    valueFormatter: params => {
                        let retour = params.value
                        try {
                            retour = moment(params.value).format('HH:mm:ss')
                        } catch (e) {

                        }
                        return retour
                    }
                },

                {
                    field: "user.matricule",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Numero Matricule',
                },
                {
                    field: "user.nom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'nom',
                },
                {
                    field: "user.prenom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'prenom',
                },
                {
                    field: "card_no",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'UUID MIFARE',
                },

                {
                    headerName: 'Terminal',
                    field: 'pointeuse.Selectlabel',
                },
                {

                    headerName: 'pointeuse',
                    field: 'pointeuse_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['pointeuse']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/pointeuses-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["Selectlabel"]}`;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['libelle'],
                    },
                },


                // {
                //     headerName: 'poste',
                //     field: 'poste.Selectlabel',
                // },
                {

                    headerName: 'poste',
                    field: 'poste_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['poste']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/postes-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["Selectlabel"]}`;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['libelle'],
                    },
                },
                // {
                //     headerName: 'direction',
                //     field: 'direction.Selectlabel',
                // },
                // {
                //
                //     headerName: 'direction',
                //     field: 'direction_id',
                //     hide: true,
                //     suppressColumnsToolPanel: true,
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['direction']['Selectlabel']
                //         } catch (e) {
                //
                //         }
                //         return retour
                //     },
                //
                //     filter: 'agSetColumnFilter',
                //     filterParams: {
                //         suppressAndOrCondition: true,
                //         keyCreator: params => params.value.id,
                //         valueFormatter: params => params.value.Selectlabel,
                //         values: params => {
                //             params.success(this.directionsData);
                //         },
                //         refreshValuesOnOpen: true,
                //     },
                // },
                // {
                //     headerName: 'faction',
                //     field: 'faction.Selectlabel',
                // },
                // {
                //
                //     headerName: 'faction',
                //     field: 'faction_id',
                //     hide: true,
                //     suppressColumnsToolPanel: true,
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['faction']['Selectlabel']
                //         } catch (e) {
                //
                //         }
                //         return retour
                //     },
                //
                //     filter: 'agSetColumnFilter',
                //     filterParams: {
                //         suppressAndOrCondition: true,
                //         keyCreator: params => params.value.id,
                //         valueFormatter: params => params.value.Selectlabel,
                //         values: params => {
                //             params.success(this.factionsData);
                //         },
                //         refreshValuesOnOpen: true,
                //     },
                // },
                // {
                //     headerName: 'site',
                //     field: 'site.Selectlabel',
                // },
                {

                    headerName: 'site',
                    field: 'site_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['site']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/sites-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["Selectlabel"]}`;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['libelle'],
                    },
                },
                // {
                //     headerName: 'sitepointeuse',
                //     field: 'sitepointeuse.Selectlabel',
                // },
                // {
                //
                //     headerName: 'sitepointeuse',
                //     field: 'sitepointeuse_id',
                //     hide: true,
                //     suppressColumnsToolPanel: true,
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['sitepointeuse']['Selectlabel']
                //         } catch (e) {
                //
                //         }
                //         return retour
                //     },
                //
                //     filter: 'agSetColumnFilter',
                //     filterParams: {
                //         suppressAndOrCondition: true,
                //         keyCreator: params => params.value.id,
                //         valueFormatter: params => params.value.Selectlabel,
                //         values: params => {
                //             params.success(this.sitesData);
                //         },
                //         refreshValuesOnOpen: true,
                //     },
                // },

                {

                    headerName: 'client',
                    field: 'client_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['client']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/clients-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["Selectlabel"]}`;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['libelle'],
                    },
                },
                // {
                //     headerName: 'fonctions',
                //     field: 'fonction.Selectlabel',
                // },
                // {
                //
                //     headerName: 'fonctions',
                //     field: 'fonction_id',
                //     hide: true,
                //     suppressColumnsToolPanel: true,
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['fonction']['Selectlabel']
                //         } catch (e) {
                //
                //         }
                //         return retour
                //     },
                //
                //     filter: 'agSetColumnFilter',
                //     filterParams: {
                //         suppressAndOrCondition: true,
                //         keyCreator: params => params.value.id,
                //         valueFormatter: params => params.value.Selectlabel,
                //         values: params => {
                //             params.success(this.fonctionsData);
                //         },
                //         refreshValuesOnOpen: true,
                //     },
                // },
                // {
                //     headerName: 'ville',
                //     field: 'ville.Selectlabel',
                // },
                // {
                //
                //     headerName: 'ville',
                //     field: 'ville_id',
                //     hide: true,
                //     suppressColumnsToolPanel: true,
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['ville']['Selectlabel']
                //         } catch (e) {
                //
                //         }
                //         return retour
                //     },
                //
                //     filter: 'agSetColumnFilter',
                //     filterParams: {
                //         suppressAndOrCondition: true,
                //         keyCreator: params => params.value.id,
                //         valueFormatter: params => params.value.Selectlabel,
                //         values: params => {
                //             params.success(this.villesData);
                //         },
                //         refreshValuesOnOpen: true,
                //     },
                // },
                // {
                //     headerName: 'zone',
                //     field: 'zone.Selectlabel',
                // },
                {

                    headerName: 'zone',
                    field: 'zone_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['zone']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/zones-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["Selectlabel"]}`;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['libelle'],
                    },
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

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
                    filter: "FiltreEntete",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/directions-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["Selectlabel"]}`;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['libelle'],
                    },
                },
            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        // let params = {};
        // try {
        //     if (typeof window.params != 'undefined') {
        //         params = window.params
        //     }
        // } catch (e) {
        // }
        // if ('debut' in params) {
        //     this.form.debut = params.debut
        // }
        // if ('fin' in params) {
        //     this.form.fin = params.fin
        // }
        this.form.debut = new Date().toISOString().slice(0, 11) + '00:00',
            this.form.fin = new Date().toISOString().slice(0, 11) + '23:59'

        console.log('voila les params', params)
        this.directionsget = this.$routeData.meta.directionsGet

        // this.getactifs();
        // this.getbalises();
        // this.getcategories();
        // this.getcontrats();
        // this.getdirections();
        // this.getechelons();
        // this.getfactions();
        // this.getfonctions();
        // this.getmatrimoniales();
        // this.getnationalites();
        // this.getonlines();
        // this.getpointeuses();
        // this.getpostes();
        // this.gettaches();
        // this.getsexes();
        // this.getsites();
        // this.getclients();
        // this.getfonctions();
        // this.getsituations();
        // this.gettypes();
        // this.getvilles();
        // this.getzones();
        // this.gettransactions();

    },
    methods: {
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        openCreateRapport() {
            this.showForm('CreateRapport', {}, this.gridApi, 'xl')
        },
        checkInDate() {
            // alert('on as chosit entre les dates et on peut desormait affricher le formulaire')
            this.key++
        },
        closeForm() {
            this.tableKey++
        },
        showForm(type, data, gridApi, width = 'lg') {
            this.formKey++
            this.formWidth = width
            this.formState = type
            this.formData = data
            this.formGridApi = gridApi
            this.$bvModal.show(this.formId)
        },
        onGridReady(params) {
            console.log('on demarre', params)
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false
        },
        getactifs() {
            this.axios.get('/api/actifs').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.actifsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getbalises() {
            this.axios.get('/api/balises').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.balisesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getclients() {
            this.axios.get('/api/clients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.clientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },


        getcategories() {
            this.axios.get('/api/categories').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.categoriesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getcontrats() {
            this.axios.get('/api/contrats').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.contratsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getdirections() {
            this.axios.get('/api/directions').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.directionsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getechelons() {
            this.axios.get('/api/echelons').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.echelonsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getfactions() {
            this.axios.get('/api/factions').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.factionsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getfonctions() {
            this.axios.get('/api/fonctions').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.fonctionsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getmatrimoniales() {
            this.axios.get('/api/matrimoniales').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.matrimonialesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getnationalites() {
            this.axios.get('/api/nationalites').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.nationalitesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getonlines() {
            this.axios.get('/api/onlines').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.onlinesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getpointeuses() {
            this.axios.get('/api/pointeuses').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.pointeusesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getpostes() {
            this.axios.get('/api/postes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.postesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        gettaches() {
            this.axios.get('/api/taches').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.tachesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getsexes() {
            this.axios.get('/api/sexes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.sexesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getsites() {
            this.axios.get('/api/sites').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.sitesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getsituations() {
            this.axios.get('/api/situations').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.situationsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        gettypes() {
            this.axios.get('/api/types').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.typesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getvilles() {
            this.axios.get('/api/villes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.villesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getzones() {
            this.axios.get('/api/zones').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.zonesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        directionsselect(direction) {

            if (this.directionselectionner.includes(direction)) {
                const index = this.directionselectionner.indexOf(direction);
                if (index !== -1) {
                    this.directionselectionner.splice(index, 1);
                }
            } else {
                this.directionselectionner.push(direction);
            }

            this.extrasData1.directionselectionner = this.directionselectionner

        },

        // gettransactions() {
        //
        //     this.axios.get('/api/transactions').then((response) => {
        //         this.requette--
        //         if (this.requette == 0) {
        //             // this.$store.commit('setIsLoading', false)
        //         }
        //         // this.transactionsData = response.data
        //         console.log('users', response.data)
        //
        //     }).catch(error => {
        //         console.log(error.response.data)
        //         // this.$store.commit('setIsLoading', false)
        //         this.$toast.error('Erreur survenue lors de la récuperation')
        //     })
        // },


    }
}
</script>
