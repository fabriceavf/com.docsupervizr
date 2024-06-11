<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Contratssites #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Contratssites</div>
            </template>

            <EditContratssites
                v-if="formState=='Update'"
                :key="formKey"
                :contratsclientsData="contratsclientsData"
                :data="formData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :prestationsData="prestationsData"
                :sitesData="sitesData"
                @close="closeForm"
            />


            <CreateContratssites
                v-if="formState=='Create'"
                :key="formKey"
                :contratsclientsData="contratsclientsData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :parentId="parentId"
                :prestationsData="prestationsData"
                :sitesData="sitesData"
                @close="closeForm"
            />

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="childBlock" style="">
            <!--            <h3>Listes des sites couvert par le contrat</h3>-->
            <AgGridTable
                :key="tableKey"
                :cacheBlockSize="cacheBlockSize"
                :columnDefs="columnDefs"
                :detailCellRenderer="detailCellRenderer"
                :extrasData="extrasData"
                :inCard="false"
                :masterDetail="true"
                :maxBlocksInCache="maxBlocksInCache"
                :pagination="pagination"
                :paginationPageSize="paginationPageSize"
                :rowData="rowData"
                :rowModelType="rowModelType"
                :showActu="false"
                :showExport="false"
                :sideBar="false"
                :url="url"
                className="ag-theme-alpine"
                domLayout='autoHeight'

                rowSelection="multiple"
                @gridReady="onGridReady"
                @first-data-rendered="onFirstDataRendered"

            >
                <template #header_buttons>
                    <!--                    <div class="btn btn-primary" v-if="!routeData.meta.hideCreate" @click="openCreate"><i-->
                    <!--                        class="fa fa-plus"></i> Nouveau-->
                    <!--                    </div>-->
                </template>

            </AgGridTable>
            <!--            <div class="newButton" @click="openCreate">-->
            <!--                <div class="">-->
            <!--                    <i class="fa-solid fa-square-plus"></i>-->
            <!--                </div>-->
            <!--            </div>-->


        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateContratssites from './CreateContratssites.vue'
import EditContratssites from './EditContratssites.vue'
import DataModal from '@/components/DataModal.vue'

import ContratspostesView from "./Contratspostes/ContratspostesView.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ContratssitesView',
    components: {
        DataTable,
        AgGridTable,
        CreateContratssites,
        EditContratssites,
        DataModal,
        AgGridBtnClicked,
        ContratspostesView
    },
    data() {

        return {
            formId: "contratssites",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/sites-Aggrid',
            table: 'contratssites',
            contratsclientsData: [],
            prestationsData: [],
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

            detailCellRenderer: null,
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
        parentId: function () {
            let id = 0
            id = this.params.data.id
            return id
        },

        extrasData: function () {
            let retour = {}
            let params = {}
            params['contratsclient_id'] = {values: [this.parentId], filterType: 'set'}
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
        this.url = this.axios.defaults.baseURL + '/api/sites-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        this.detailCellRenderer = 'ContratspostesView';

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
                    width: 10,
                    pinned: 'left',
                    cellRenderer: 'agGroupCellRenderer'
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
                                    this.showForm('Update', field, params.api)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },

                {
                    headerName: 'site',
                    field: 'site.Selectlabel',
                },
                {
                    headerName: 'prestation',
                    field: 'prestation.Selectlabel',
                },
                {
                    field: "agentsjour",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'nbrs agents jour',
                },


                {
                    field: "agentsnuit",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'nbrs agents nuit',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'prestation',
                    field: 'prestation_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['prestation']['Selectlabel']
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
                            params.success(this.prestationsData);
                        },
                        refreshValuesOnOpen: true,
                    },
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

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getcontratsclients();
        // this.getprestations();
        // this.getsites();

    },
    methods: {
        onFirstDataRendered(params) {
            params.api.forEachNode(function (node) {
                node.setExpanded(node.id === '1');
            });
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

            this.gridApi.sizeColumnsToFit();
        },
        getcontratsclients() {
            this.axios.get('/api/clients').then((response) => {
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

        getprestations() {
            this.axios.get('/api/prestations').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.prestationsData = response.data

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
