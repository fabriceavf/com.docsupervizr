<template>

    <div>
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Actionsprevisionelles #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Actionsprevisionelles</div>
            </template>

            <EditActionsprevisionelles
                v-if="formState=='Update'"
                :key="formKey"
                :besoinsData="besoinsData"
                :data="formData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                @close="closeForm"
            />


            <CreateActionsprevisionelles
                v-if="formState=='Create'"
                :key="formKey"
                :besoinsData="besoinsData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                @close="closeForm"
            />

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <div class="col-sm-12">
            <div v-if="allDatas.length==0" class="btn">Aucun processus de realisation de lobjectif na ete defini</div>
            <div v-else class="btn">Demarche a suivre pour realiser l'objectifs</div>
            <div v-if="params.data.valider!='1'" class="btn btn-primary createButton" @click="openCreate"><i
                class="fa fa-plus"></i></div>
        </div>
        <div id="Actionsprevisionelles-table" class="col-sm-12">
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
                :sideBar="{}"
                :url="url"
                className="ag-theme-alpine"
                domLayout='autoHeight'
                rowSelection="multiple"
                @gridReady="onGridReady"
                @newData="newData"
            >
                <template #header_buttons>

                </template>

            </AgGridTable>
        </div>
        <div style="margin:10px auto; text-align:center">


        </div>


    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateActionsprevisionelles from './CreateActionsprevisionelles.vue'
import EditActionsprevisionelles from './EditActionsprevisionelles.vue'
import DataModal from '@/components/DataModal.vue'
import ActionsprevisionnellesCard from "./ActionsprevisionnellesCard.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ActionsprevisionellesView',
    components: {
        DataTable,
        AgGridTable,
        CreateActionsprevisionelles,
        EditActionsprevisionelles,
        DataModal,
        AgGridBtnClicked,
        ActionsprevisionnellesCard
    },
    props: ['parentId'],
    data() {

        return {
            formId: "actionsprevisionelles",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/actionsprevisionelles-Aggrid',
            table: 'actionsprevisionelles',
            besoinsData: [],
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
            allDatas: []
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
            let params = {baseFilter: {}}
            params['baseFilter']['besoin_id'] = {values: [this.params.data.id], filterType: 'set'}
            return params


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
        this.url = this.axios.defaults.baseURL + '/api/actionsprevisionelles-Aggrid',
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
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },


                {
                    field: "descriptions",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'descriptions',
                },


                {
                    field: "debut_previsionnel",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'debut_previsionnel',
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
                    field: "fin_previsionnel",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'fin_previsionnel',
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
                    field: "debut_reel",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'debut_reel',
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
                    field: "fin_reel",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'fin_reel',
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
                    field: "creat_by",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'creat_by',
                },


                {
                    field: "evaluation",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'evaluation',
                },


                {
                    field: "valider",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'valider',
                },


                {
                    headerName: 'besoin',
                    field: 'besoin.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'besoin',
                    field: 'besoin_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['besoin']['Selectlabel']
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
                            params.success(this.besoinsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },

            ];

        this.columnDefs = [
            {
                field: null,
                headerName: 'Actions',
                suppressCellSelection: true,
                autoHeight: true,
                cellRendererSelector: params => {
                    return {
                        component: 'ActionsprevisionnellesCard',
                        params: {
                            clicked: field => {
                                this.showForm('Update', field, params.api)
                            },
                            updateElement: field => {
                                this.showForm('Update', field, params.api)
                            },
                            deleteElement: field => {
                                this.showForm('Update', field, params.api)
                            },
                            showChild: field => {
                                console.log('on veut afficher', Object.getOwnPropertyNames(params.api));
                                // console.log('on veut afficher',params.api.get)
                                // params.api.getRow()
                                params.api.getRowNode(1).setExpanded(true)

                                this.showForm('Update', field, params.api)
                            },
                            hideChild: field => {

                                this.showForm('Update', field, params.api)
                            },
                        }
                    };
                },
            },];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        this.besoinsData = [this.params.data]

    },
    methods: {


        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        updateElement(data) {
            this.showForm('Update', {}, this.gridApi, data)
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
        newData(data) {
            console.log('voici la data', data)
            this.allDatas = data.rowData
        },
        getbesoins() {
            this.axios.get('/api/besoins').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.besoinsData = response.data

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
#Actionsprevisionelles-table .ag-paging-panel {
    display: none !important;
}
</style>
