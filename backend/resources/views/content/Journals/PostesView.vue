<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Postes #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Postes</div>
            </template>


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="childBlock">
            <h3>Pointeuse : {{ data.pointeuse.Selectlabel }}</h3>
            <AgGridTable
                :key="tableKey"
                :cacheBlockSize="cacheBlockSize"
                :columnDefs="columnDefs"
                :extrasData="extrasData"
                :getRowStyle="getRowStyle"
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
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'PostesView',
    components: {DataTable, AgGridTable, DataModal, AgGridBtnClicked},
    props: ['data'],

    data() {

        return {
            formId: "postes",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/postes-Aggrid',
            table: 'postes',
            contratsclientsData: [],
            clientsData: [],
            zonesData: [],
            pointeusesData: [],
            sitesData: [],
            requette: 3,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
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
            let retour = {}
            let params = {}

            params['id'] = {values: this.data.PostesPotentiels.map(data => data.id), filterType: 'set'}


            retour['baseFilter'] = params

            return retour


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
        this.url = this.axios.defaults.baseURL + '/api/postes-Aggrid',
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
                    field: "code",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'code',
                },

                {
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },

                {
                    headerName: 'contrats',
                    field: 'contratsclient.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'contratsclient',
                    field: 'contratsclient_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['contratsclient']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },

                    filter: 'agSetColumnFilter',
                    filterParams: {
                        suppressAndOrCondition: true,
                        keyCreator: params => params.value.id,
                        valueFormatter: params => params.value.libelle,
                        values: params => {
                            params.success(this.contratsclientsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },

                {
                    headerName: 'client',
                    field: 'site.client.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'client',
                    field: 'client_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['client']['Selectlabel']
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
                            params.success(this.clientsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },

                {
                    headerName: 'site',
                    field: 'site.Selectlabel',
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
                    field: null,
                    headerName: 'pointeuses',
                    suppressCellSelection: true,
                    cellRendererSelector: params => {
                        let pointeuses = 0;
                        try {
                            pointeuses = params.data.pointeuses.length
                        } catch (e) {
                        }
                        let retour = {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                },
                                render: `<div class="" style="width:100%;height:100%;color:black;border-radius:5px;text-align:center;cursor:pointer"> ${pointeuses} Pointeuses </div>`
                            }
                        }
                        if (pointeuses <= 0) {
                            retour = {
                                component: 'AgGridBtnClicked',
                                params: {
                                    clicked: field => {
                                    },
                                    render: `<div class="" style="width:100%;height:100%;color:red;border-radius:5px;text-align:center;cursor:pointer"><i class="fa-solid fa-triangle-exclamation"></i> ${pointeuses} pointeuse  </div>`
                                }
                            }
                        }
                        return retour;
                    },

                },

                {
                    field: "jours",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'jours couverts',
                },
                {
                    field: "Agentjour",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Agents Jours',
                },
                {
                    field: "Agentnuit",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Agents Nuits',
                },


                {
                    headerName: 'zone',
                    field: 'site.zone.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

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

                {
                    headerName: 'pointeuse',
                    field: 'pointeuse.Selectlabel',
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

                    filter: 'agSetColumnFilter',
                    filterParams: {
                        suppressAndOrCondition: true,
                        keyCreator: params => params.value.id,
                        valueFormatter: params => params.value.Selectlabel,
                        values: params => {
                            params.success(this.pointeusesData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getcontratsclients();
        // this.getclients();
        // this.getzones();
        // this.getpointeuses();
        // this.getsites();

    },
    methods: {

        getRowStyle(params) {
            let style = {}
            console.log('RowParams===', params)
            try {

                if (!params.data.IsCouvert) {
                    style.background = "#ff000070"
                }
                if (params.data.couvertAgentjour || params.data.couvertAgentnuit) {
                    style.background = "#ECA84C"
                }
            } catch (e) {

            }
            return style;
        },
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
        getcontratsclients() {
            this.axios.get('/api/contratsclients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.contratsclientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getclients() {
            this.axios.get('/api/clients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.clientsData = response.data

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

<style>
.ag-root-wrapper {
    border-radius: 5px
}

.childBlock {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 95%;
    margin: 10px auto;
}

.newButton {
    text-align: center;
    margin: 0 auto;
    position: absolute;
    top: 15px;
    right: 30px;
    border-radius: 5px;
    padding: 10px;
    background: #0004ff;
    color: #fff;
}
</style>
