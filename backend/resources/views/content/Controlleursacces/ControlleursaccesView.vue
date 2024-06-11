<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Controlleursacces #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Controlleursacces</div>
            </template>

            <EditControlleursacces
                v-if="formState=='Update'"
                :key="formKey"
                :data="formData"
                :deplacementsData="deplacementsData"
                :gridApi="formGridApi"
                :lignesData="lignesData"
                :modalFormId="formId"
                :pointeusesData="pointeusesData"
                :sitesData="sitesData"
                @close="closeForm"
            />


            <CreateControlleursacces
                v-if="formState=='Create'"
                :key="formKey"
                :deplacementsData="deplacementsData"
                :gridApi="formGridApi"
                :lignesData="lignesData"
                :modalFormId="formId"
                :pointeusesData="pointeusesData"
                :sitesData="sitesData"
                @close="closeForm"
            />

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


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
                :url="url"
                className="ag-theme-alpine"
                domLayout='autoHeight'
                rowSelection="multiple"
                @gridReady="onGridReady"

            >
                <template #header_buttons>
                    <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> Nouveau
                    </div>
                    <input v-model="week" class="form-control" placeholder="Veuillez selectioner le mois"
                           style="width: auto !important" type="week"/>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateControlleursacces from './CreateControlleursacces.vue'
import EditControlleursacces from './EditControlleursacces.vue'
import Ratachement from './Ratachement.vue'
import CustomSelect from "@/components/CustomSelect.vue"
import CustomFiltre from "@/components/CustomFiltre.vue"
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ControlleursaccesView',
    components: {
        DataTable,
        AgGridTable,
        CreateControlleursacces,
        EditControlleursacces,
        DataModal,
        AgGridBtnClicked,
        CustomSelect,
        CustomFiltre,
        Ratachement
    },
    data() {

        return {
            formId: "controlleursacces",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/controlleursacces-Aggrid',
            table: 'controlleursacces',
            lignesData: [],
            deplacementsData: [],
            pointeusesData: [],
            sitesData: [],
            requette: 4,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            week: null
        }
    },

    computed: {
        routeData: function () {
            let router = {meta: {}}
            if (window.router) {
                try {
                    router = window.router;
                } catch (e) {
                }
            }


            return router
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
            if (!this.week) {
                // params["id"] = { values: [0], filterType: "set" };
            }
            this.tableKey++;

            return {
                baseFilter: params,
                week: this.week,
            };
        },
    },
    watch: {
        'routeData': {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null)
                this.gridApi.refreshServerSide()
            },
            deep: true
        },
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/controlleursacces-Aggrid',
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
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-raduis:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },


                {
                    headerName: 'Terminal ',
                    field: 'pointeuse.code',

                },
                {

                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'pointeuse',
                    field: 'pointeuse_id',
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
                {
                    headerName: 'affectation',
                    field: null,
                    minWidth: 350,
                    cellRendererSelector: params => {
                        return {
                            component: 'Ratachement',
                        }
                    }
                },
                {

                    hide: true,
                    suppressColumnsToolPanel: true,

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
                {

                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'deplacement',
                    field: 'deplacement_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['deplacement']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },

                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/deplacements-Aggrid',
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

                    headerName: 'ligne',
                    field: 'ligne_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['ligne']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },

                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/lignes-Aggrid',
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
                    field: "date_debut",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'date_debut',
                },
                {
                    field: "date_fin",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'date_fin',
                },


                {

                    maxWidth: 100,
                    field: "lun",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'lun',
                },


                {
                    maxWidth: 100,
                    field: "mar",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'mar',
                },


                {
                    maxWidth: 100,
                    field: "mer",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'mer',
                },


                {
                    maxWidth: 100,
                    field: "jeu",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'jeu',
                },


                {
                    maxWidth: 100,
                    field: "ven",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'ven',
                },


                {
                    maxWidth: 100,
                    field: "sam",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'sam',
                },


                {
                    maxWidth: 100,
                    field: "dim",
                    sortable: true,
                    // filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'dim',
                },


            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        this.getlignes();
        this.getdeplacements();
        this.getpointeuses();
        this.getsites();

    },
    methods: {
        closeForm() {
            this.tableKey++
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
        onGridReady(params) {
            console.log('on demarre', params)
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false
        },
        getlignes() {
            this.axios.get('/api/lignes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.lignesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getdeplacements() {
            this.axios.get('/api/deplacements').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.deplacementsData = response.data

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

    }
}
</script>
