<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Postes #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Postes</div>
            </template>

            <EditPostes
                v-if="formState=='Update'"
                :key="formKey"
                :contratsclientsData="contratsclientsData"
                :data="formData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :pointeusesData="pointeusesData"
                :sitesData="sitesData"
                @close="closeForm"
            />


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="childBlock">
            <AgGridTable
                :key="tableKey"
                :cacheBlockSize="cacheBlockSize"
                :columnDefs="columnDefs"
                :extrasData="extrasData"
                :inCard="false"
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
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import EditPostes from '../Postes/EditPostes.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'PostesView',
    components: {DataTable, AgGridTable, EditPostes, DataModal, AgGridBtnClicked},

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
            let AllId = false
            let ContratsclientId = false
            try {
                AllId = this.params.data.id
            } catch (e) {

            }
            try {
                ContratsclientId = this.params.api._ContratsclientId
            } catch (e) {

            }
            if (AllId) {
                params['site_id'] = {values: [AllId], filterType: 'set'}
            }
            if (ContratsclientId) {
                params['contratsclient_id'] = {values: [ContratsclientId], filterType: 'set'}
            }
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
        console.log('voici les params dans postes', this.params)

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
                    minWidth: 80, maxWidth: 80,
                    pinned: 'left',
                    cellRendererSelector: params => {
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api, "xl")
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },

                {
                    field: "code",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'code du poste',
                },

                {
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle du poste',
                },

                // {
                //     headerName: 'contrats',
                //     field: 'contratsclient.Selectlabel',
                // },
                // {
                //     hide: true,
                //     suppressColumnsToolPanel: true,
                //
                //     headerName: 'contratsclient',
                //     field: 'contratsclient_id',
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['contratsclient']['Selectlabel']
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
                //             params.success(this.contratsclientsData);
                //         },
                //         refreshValuesOnOpen: true,
                //     },
                // },
                //
                // {
                //     headerName: 'client',
                //     field: 'site.client.Selectlabel',
                // },
                //
                // {
                //     headerName: 'site',
                //     field: 'site.Selectlabel',
                // },
                // {
                //     hide: true,
                //     suppressColumnsToolPanel: true,
                //
                //     headerName: 'site',
                //     field: 'site_id',
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['site']['Selectlabel']
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
                    field: "jours",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'jours',
                },
                {
                    field: "maxjours",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Agents Jours',
                },
                {
                    field: "maxnuits",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Agents Nuits',
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
        // this.getpointeuses();
        // this.getsites();

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

            this.gridApi.sizeColumnsToFit();
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
