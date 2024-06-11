<template>

    <b-overlay :show="isLoading">

        <div class="dataParents">

            <div v-if="hasDescription" class="col-sm-12 dataBlock">
                <h6><i class="fa-solid fa-note-sticky"></i> Description du travail a faire</h6>
                <Messages :disable="true" :donnes="parent.description"></Messages>

            </div>
            <div v-else class="col-sm-12 dataBlock">
                <h6><i class="fa-solid fa-note-sticky"></i> Aucune description du travail a faire</h6>

            </div>

            <div v-if="parent.has_child" class="parents dataBlock">

                <h6 style="cursor:pointer" @click="showAll=!showAll"><i class="fa-solid fa-bars-staggered"></i> Ensemble
                    des sous taches</h6>

                <div v-if="showAll" class="row">
                    <div class="statistiques">
                        <!--                        <statistic-card-horizontal :statistic="0" background="rgb(255, 159, 67)" color="success"-->
                        <!--                                                   icon="UsersIcon" statistic-title="Non Demarrer"/>-->
                        <!--                        <statistic-card-horizontal :statistic="0" background="rgb(255, 159, 67)" color="success"-->
                        <!--                                                   icon="UsersIcon" statistic-title="Terminer"/>-->
                        <!--                        <statistic-card-horizontal :statistic="0" background="rgb(255, 159, 67)" color="success"-->
                        <!--                                                   icon="UsersIcon" statistic-title="En cours"/>-->
                        <!--                        <statistic-card-horizontal :statistic="0" background="rgb(255, 159, 67)" color="success"-->
                        <!--                                                   icon="UsersIcon" statistic-title="Bloquer"/>-->
                        <button class="btn btn-secondary">
                            <i class="fas fa-floppy-disk"></i> Non Demarrer ( 0 )
                        </button>
                        <button class="btn btn-primary" type="button">
                            <i class="fa-solid fa-circle-check"></i> Terminer ( 0 )
                        </button>
                        <button class="btn btn-warning" type="button">
                            <i class="fa-solid fa-hourglass-half"></i> En cours ( 0 )
                        </button>
                        <button class="btn btn-danger" type="button">
                            <i class="fa-solid fa-triangle-exclamation"></i> Bloquer ( 0 )
                        </button>

                    </div>

                </div>
                <div v-if="showAll" class="row">
                    <b-modal :id="formId" :size="formWidth">
                        <template #modal-title>
                            <div v-if="formState=='Update'">Update Activites #{{ formData.id }}</div>
                            <div v-if="formState=='Create'">Create Activites</div>
                        </template>

                        <EditActivites
                            v-if="formState=='Update'"
                            :key="formKey"
                            :data="formData"
                            :gridApi="formGridApi"
                            :modalFormId="formId"
                            :usersData="usersData"
                            @close="closeForm"
                        />


                        <CreateActivites
                            v-if="formState=='Create'"
                            :key="formKey"
                            :gridApi="formGridApi"
                            :modalFormId="formId"
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
                            :detailCellRenderer="detailCellRenderer"
                            :extrasData="extrasData"
                            :getRowStyle="getRowStyle"
                            :inCard="false"
                            :masterDetail="true"
                            :maxBlocksInCache="maxBlocksInCache"
                            :pagination="pagination"
                            :paginationPageSize="paginationPageSize"
                            :rowData="rowData"
                            :rowHeight="60"
                            :rowModelType="rowModelType"
                            :sideBar="false"
                            :suppressRowHoverHighlight="true"
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

            </div>
        </div>

    </b-overlay>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateActivites from './CreateActivites.vue'
import EditActivites from './EditActivites.vue'
import DataModal from '@/components/DataModal.vue'

import StatisticCardHorizontal from '@core/components/statistics-cards/StatisticCardHorizontal.vue'
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import ActivitesActions from "./ActivitesActions.vue"
import Messages from './Messages.vue'


export default {
    name: 'ActivitesChildView',
    components: {
        DataTable,
        AgGridTable,
        CreateActivites,
        EditActivites,
        DataModal,
        AgGridBtnClicked,
        Messages,
        ActivitesActions,
        StatisticCardHorizontal

    },
    data() {

        return {
            isLoading: false,
            formId: "activites",
            formState: "",
            formData: {},
            formWidth: 'xl',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/activites-Aggrid',
            table: 'activites',
            requette: 0,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            usersData: [],
            autoGroupColumnDef: {},
            detailCellRenderer: null,
            showAll: false


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
        parent: function () {
            return this.params.data
        },
        extrasData: function () {
            let params = {}
            params['parent'] = {values: [this.parent.id], filterType: 'set'}
            return {'baseFilter': params}
        },
        hasDescription: function () {

            return this.parent.description != "" && this.parent.description != null
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
        this.url = this.axios.defaults.baseURL + '/api/activites-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        this.detailCellRenderer = "ActivitesChildView"
        console.log('voici les parametres passer en props par defaults dans la listes des activites', this.params.data)


    },
    beforeMount() {
        this.columnDefs =
            [

                // {
                //     field: null,
                //     headerName: '',
                //     suppressCellSelection: true,
                //     minWidth: 80,maxWidth: 80,
                //     pinned: 'left',
                //     cellRendererSelector: params => {
                //         return {
                //             component: 'AgGridBtnClicked',
                //             params: {
                //                 clicked: field => {
                //                     this.showForm('Update', field, params.api, 'xl')
                //                 },
                //                 render: `<div class="updateButton" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer;">  <i class="fa-solid fa-pen-to-square "></i></div>`
                //             }
                //         };
                //     },
                //
                // },
                // {
                //     field: null,
                //     headerName: '',
                //     maxminWidth: 80,maxWidth: 80,
                //
                //     pinned: 'left',
                //     cellRenderer: 'agGroupCellRenderer'
                // },
                //
                // {
                //     field: "libelle",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'libelle',
                //     cellRenderer: 'agGroupCellRenderer'
                // },


                {
                    field: null,
                    headerName: 'Actions',
                    suppressCellSelection: true,
                    cellRendererSelector: params => {
                        return {
                            component: 'ActivitesActions',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api, 'xl')
                                },
                                updateElement: field => {
                                    this.showForm('Update', field, params.api, 'xl')
                                },
                                deleteElement: field => {
                                    this.showForm('Update', field, params.api, 'xl')
                                },
                                showChild: field => {
                                    console.log('on veut afficher', Object.getOwnPropertyNames(params.api));
                                    // console.log('on veut afficher',params.api.get)
                                    // params.api.getRow()
                                    params.api.getRowNode(1).setExpanded(true)

                                    this.showForm('Update', field, params.api, 'xl')
                                },
                                hideChild: field => {

                                    this.showForm('Update', field, params.api, 'xl')
                                },
                            }
                        };
                    },


                },

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.getusers()


    },
    methods: {

        closeForm() {
            this.tableKey++
        },

        openCreate() {
            this.showForm('Create', {}, this.gridApi, 'lg')
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
        getRowStyle(params) {
            console.log('RowParams===', params)
            console.log('rowStyle ==>')
            return {
                // background: '#fff',
                // border:"1px solid black",
                // borderRadius:"5px",
                // margin:"5px",
            };
        },

        getusers() {
            this.isLoading = true
            this.axios.get('/api/users/type_id/1').then((response) => {

                this.isLoading = false
                this.usersData = response.data

            }).catch(error => {
                this.isLoading = false

                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
    }
}
</script>
<style>
.parents .ag-theme-alpine .ag-header {
    display: none

}

.parents .ag-theme-alpine .ag-row {
    border-bottom: 1px solid #fff !important

}

.parents .ag-theme-alpine .ag-row:hover {
    background: #fff !important;

}

.parents .ag-theme-alpine {
    --ag-borders: none;
    --ag-alpine-active-color: #fff;

}

.ag-root-wrapper {
    border-radius: 5px
}

.parents .ag-theme-alpine .ag-paging-panel {
    display: none
}

.ag-root-wrapper {
    border-radius: 5px
}

.dataParents {
    display: flex;
    gap: 10px;
    padding: 25px 0px;
    flex-direction: column;
    width: 97%;
    margin: 0 auto;
}

.dataBlock {
    box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px;
    width: 98%;
    margin: 0 auto;
    padding: 10px;
    border: 1px solid #04040438;
    border-radius: 5px;
}

.parents {
    display: flex;
    gap: 10px;
    flex-direction: column;
}

.statistiques {
    width: 90%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
}
</style>
