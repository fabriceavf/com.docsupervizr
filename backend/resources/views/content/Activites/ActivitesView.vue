<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'"></div>
                <div v-if="formState=='Create'"></div>
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
                :usersData="usersData"
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
                :getRowStyle="getRowStyle"
                :maxBlocksInCache="maxBlocksInCache"
                :pagination="pagination"
                :paginationPageSize="paginationPageSize"
                :rowData="rowData"
                :rowModelType="rowModelType"
                :sideBar="false"
                :url="url"
                className="ag-theme-alpine"
                domLayout='autoHeight'
                rowSelection="multiple"
                @gridReady="onGridReady"


            >
                <template #header_buttons>
                    <div v-if="!$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> Nouveau {{ $routeData.meta.hideCreate }}
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateActivites from './CreateActivites.vue'
import EditActivites from './EditActivites.vue'
import DataModal from '@/components/DataModal.vue'

import ActivitesActions from "./ActivitesActions.vue"
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ActivitesView',
    components: {
        DataTable,
        AgGridTable,
        CreateActivites,
        EditActivites,
        DataModal,
        AgGridBtnClicked,
        ActivitesActions
    },
    data() {

        return {
            formId: "activites",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/activites-Aggrid',
            table: 'activites',
            usersData: [],
            requette: 1,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            type: false
        }
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
            params['type'] = {values: [this.$routeData.meta.type], filterType: 'set'}

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
        this.url = this.axios.defaults.baseURL + '/api/activites-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

    },
    beforeMount() {
        this.columnDefs =
            [
                // {
                //     field: null,
                //     headerName: '',
                //     suppressCellSelection: true,
                //     maxminWidth: 80,maxWidth: 80,
                //     pinned: 'left',
                //     cellRendererSelector: params => {
                //         return {
                //             component: 'AgGridBtnClicked',
                //             params: {
                //                 clicked: field => {
                //                     this.showForm('Update', field, params.api,'xl')
                //                 },
                //                 render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                //             }
                //         };
                //     },
                //
                // },


                {
                    field: null,
                    headerName: 'Actions',
                    suppressCellSelection: true,
                    autoHeight: true,
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

                //
                // {
                //     field: "duree",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'duree',
                // },
                //
                //
                // {
                //     field: "parent",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'parent',
                // },
                //
                //
                // {
                //     field: "has_child",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'has_child',
                // },
                //
                //
                // {
                //     field: "description",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'description',
                // },
                //
                //
                // {
                //     field: "type",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'type',
                // },


                // {
                //     headerName: 'user',
                //     field: 'user.Selectlabel',
                // },
                // {
                //     hide: true,
                //     suppressColumnsToolPanel: true,
                //
                //     headerName: 'user',
                //     field: 'user_id',
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['user']['Selectlabel']
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
                //             params.success(this.usersData);
                //         },
                //         refreshValuesOnOpen: true,
                //     },
                // },

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getusers();

    },
    methods: {
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        showData(type) {
            if (this.type == type) {
                this.type = false
            } else {
                this.type = type
            }
            alert('on update le type')
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
        getusers() {
            this.axios.get('/api/users').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.usersData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
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

    }
}
</script>

<style>
.ag-theme-alpine .ag-header {
    display: none

}

.ag-theme-alpine .ag-row {
    border-bottom: 1px solid #fff !important

}

.ag-theme-alpine .ag-row:hover {
    background: #fff !important;

}

.ag-theme-alpine {
    --ag-borders: none;
    --ag-alpine-active-color: #fff !important;
    --ag-row-hover-color: #fff !important;

}

.ag-root-wrapper {
    border-radius: 5px
}

.ag-theme-alpine .ag-paging-panel {
    /*display: none*/
}

.ag-root-wrapper {
    border-radius: 5px;
    border-color: #fff
}
</style>
