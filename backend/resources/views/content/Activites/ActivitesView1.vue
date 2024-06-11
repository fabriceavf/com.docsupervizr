<template>

    <b-overlay :show="isLoading">
        <div class="row">
            <b-modal :id="formId" :size="formWidth">
                <template #modal-title>
                    <div v-if="formState=='Update'">Update Activites #{{ formData.id }}</div>
                    <div v-if="formState=='Create'">Create Activites</div>
                </template>

                <EditActivites
                    v-if="formState=='Update' && formData.validate!=1"
                    :key="formKey"
                    :data="formData"
                    :gridApi="formGridApi"
                    :modalFormId="formId"
                    :usersData="usersData"
                    @close="closeForm"
                />
                <DetailsActivites
                    v-if="formState=='Update'  && formData.validate==1"
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
                    :masterDetail="true"
                    :maxBlocksInCache="maxBlocksInCache"
                    :pagination="pagination"
                    :paginationPageSize="paginationPageSize"
                    :rowData="rowData"
                    :rowHeight="45"
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
            <div class="col-sm-12">
                <PlanificationsView></PlanificationsView>

            </div>
        </div>
    </b-overlay>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateActivites from './CreateActivites.vue'
import EditActivites from './EditActivites.vue'
import DetailsActivites from './DetailsActivites.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import ActivitesActions from "./ActivitesActions.vue"
import Messages from './Messages.vue'
import ActivitesChildView from './ActivitesChildView.vue'
import PlanificationsView from "./PlanificationsView.vue";

import Calcules1 from "../Calcules1.vue";

export default {
    name: 'ActivitesView',
    components: {
        DataTable,
        AgGridTable,
        CreateActivites,
        EditActivites,
        DataModal,
        AgGridBtnClicked,
        Messages,
        ActivitesActions,
        ActivitesChildView,
        Calcules1,
        PlanificationsView, DetailsActivites


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
            let params = {}
            params['parent'] = {values: [0], filterType: 'set'}
            return {'baseFilter': params}
        }
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
        this.autoGroupColumnDef = {
            field: 'id',
            cellRendererParams: {
                innerRenderer: (params) => {
                    // display employeeName rather than group key (employeeId)
                    return params.data.libelle;
                },
            },
        };
        this.detailCellRenderer = "ActivitesChildView"


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
                    headerName: 'Activites',
                    suppressCellSelection: true,
                    cellRendererSelector: params => {
                        return {
                            component: 'ActivitesActions',
                            params: {
                                clicked: field => {
                                    let action = "Update"
                                    this.showForm(action, field, params.api, 'xl')
                                },
                                updateElement: field => {
                                    let action = "Update"
                                    this.showForm(action, field, params.api, 'xl')
                                },
                                deleteElement: field => {
                                    let action = "Update"
                                    this.showForm(action, field, params.api, 'xl')
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
        // indicate if row is a group node
        isServerSideGroup(dataItem) {
            return dataItem.has_child;
        },

// specify which group key to use
        getServerSideGroupKey(dataItem) {
            return dataItem.id;
        },

        closeForm() {
            this.tableKey++
        },

        openCreate() {
            this.showForm('Create', {}, this.gridApi, 'lg')
        },

        showForm(type, data, gridApi, width = 'lg') {
            if (data.validate == 1) {
                width = 'lg'
            }
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
.ag-theme-alpine {
    --ag-alpine-active-color: #fff;

}
</style>
