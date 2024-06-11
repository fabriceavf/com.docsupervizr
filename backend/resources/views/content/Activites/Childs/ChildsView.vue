<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Childs #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Childs</div>
            </template>


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="col-sm-12">

            <div class="container dataBlock" style="display: flex; justify-content: space-between">
                <button v-if="parentType=='objectifs'" class="btn">
                    <i class="fa-solid fa-sitemap"></i> Listes des objectifs a atteindre
                </button>
                <button v-if="parentType=='actions'" class="btn">
                    <i class="fa-solid fa-sitemap"></i> Listes des actions a mener pour atteindre l'objectifs
                </button>
                <button v-if="!formState" class="btn btn-success" @click="openCreate">
                    <i class="fa-solid fa-square-plus"></i> Nouveau
                </button>
            </div>
            <EditChilds
                v-if="formState=='Update'"
                :key="formKey"
                :data="formData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :parentId="parentId"
                :parentKey="parentKey"
                :parentType="parentType"
                :parentValue="parentValue"
                :usersData="usersData"
                class="dataBlock"
                style="width:80%;margin:0 auto"
                @close="closeForm"

            />


            <CreateChilds
                v-if="formState=='Create'"
                :key="formKey"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :parentId="parentId"
                :parentKey="parentKey"
                :parentType="parentType"
                :parentValue="parentValue"
                :usersData="usersData"
                class="dataBlock"
                style="width:80%;margin:0 auto"
                @close="closeForm"
            />
            <AgGridTable v-show="!formState"
                         :key="tableKey"
                         :cacheBlockSize="cacheBlockSize"
                         :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :getRowStyle="getRowStyle"
                         :inCard="false"
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
import CreateChilds from './CreateChilds.vue'
import EditChilds from './EditChilds.vue'
import DataModal from '@/components/DataModal.vue'

import ChildsActions from "./ChildsActions.vue"
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ChildsView',
    components: {
        DataTable,
        AgGridTable,
        CreateChilds,
        EditChilds,
        DataModal,
        AgGridBtnClicked,
        ChildsActions
    },
    props: ["parentKey", 'parentValue', "parentId", "parentType"],
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
            params['type'] = {values: [this.parentType], filterType: 'set'}
            params['parent'] = {values: [this.parentId], filterType: 'set'}
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
                            component: 'ChildsActions',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api, 'xl')
                                },
                                updateElement: field => {
                                    this.showForm('Update', field, params.api, 'xl')
                                },
                                validateElement: field => {
                                    this.validateLine(field)
                                },
                                deleteElement: field => {
                                    this.deleteLine(field)
                                },
                                showChild: field => {
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

        // this.getusers();

    },
    methods: {
        closeForm() {
            this.formState = false
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
            // this.$bvModal.show(this.formId)
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
        validateLine(donne) {
            this.isLoading = true
            let data = {
                validate: 1
            }


            this.axios.post('/api/activites/' + donne.id + '/update', data).then(response => {
                this.isLoading = false
                this.gridApi.refreshServerSide()
                this.$toast.success('Operation effectuer avec succes')
                this.closeForm()
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        deleteLine(donne) {
            this.isLoading = true
            let data = {
                validate: 1
            }

            this.form.description = this.description

            this.axios.post('/api/activites/' + donne.id + '/delete').then(response => {
                this.isLoading = false
                this.gridApi.refreshServerSide()
                this.$toast.success('Operation effectuer avec succes')
                this.closeForm()
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
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

.ag-theme-alpine .ag-layout-auto-height .ag-center-cols-clipper, .ag-theme-alpine .ag-layout-auto-height .ag-center-cols-container, .ag-theme-alpine .ag-layout-print .ag-center-cols-clipper, .ag-theme-alpine .ag-layout-print .ag-center-cols-container, .ag-theme-alpine-dark .ag-layout-auto-height .ag-center-cols-clipper, .ag-theme-alpine-dark .ag-layout-auto-height .ag-center-cols-container, .ag-theme-alpine-dark .ag-layout-print .ag-center-cols-clipper, .ag-theme-alpine-dark .ag-layout-print .ag-center-cols-container {
    min-height: 0px !important;;
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


.dataBlock {
    box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px;
    width: 98%;
    margin: 10px auto;
    padding: 10px;
    border: 1px solid #04040438;
    border-radius: 5px;
}

.ag-root-wrapper {
    border-radius: 5px;
    border-color: #fff
}
</style>
