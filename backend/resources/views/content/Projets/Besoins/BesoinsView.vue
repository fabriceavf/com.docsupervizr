<template>

    <div style="padding:10px;margin:0 auto">

        <div class="row dataBlock">
            <b-modal :id="formId" :size="formWidth">
                <template #modal-title>
                    <div v-if="formState=='Update'">Update Besoins #{{ formData.id }}</div>
                    <div v-if="formState=='Create'">Create Besoins</div>
                </template>

                <EditBesoins
                    v-if="formState=='Update'"
                    :key="formKey"
                    :data="formData"
                    :gridApi="formGridApi"
                    :modalFormId="formId"
                    :projetsData="projetsData"
                    @close="closeForm"
                />


                <CreateBesoins
                    v-if="formState=='Create'"
                    :key="formKey"
                    :gridApi="formGridApi"
                    :modalFormId="formId"
                    :projetsData="projetsData"
                    @close="closeForm"
                />

                <template #modal-footer>
                    <div></div>
                </template>
            </b-modal>
            <div class="col-sm-12">
                <div class="btn">Listes des besoins client du projet</div>
                <div v-if="!routeData.meta.hideCreate" class="btn btn-primary createButton" @click="openCreate"><i
                    class="fa fa-plus"></i></div>
            </div>

            <div class="col-sm-12">

                <AgGridTable
                    :key="tableKey"
                    :cacheBlockSize="cacheBlockSize"
                    :columnDefs="columnDefs"
                    :detailCellRenderer="detailCellRenderer"
                    :extrasData="extrasData"
                    :inCard="false"
                    :maxBlocksInCache="maxBlocksInCache"
                    :pagination="pagination"
                    :paginationPageSize="paginationPageSize"
                    :rowData="rowData"
                    :rowModelType="rowModelType"
                    :showActu="false"
                    :showExport="false"
                    :sideBar="{}"
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
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateBesoins from './CreateBesoins.vue'
import EditBesoins from './EditBesoins.vue'
import DataModal from '@/components/DataModal.vue'
import ActionsprevisionellesView from "./Actionsprevisionelles/ActionsprevisionellesView.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import BesoinsCard from "./BesoinsCard.vue";

export default {
    name: 'BesoinsView',
    components: {
        DataTable,
        AgGridTable,
        CreateBesoins,
        EditBesoins,
        DataModal,
        AgGridBtnClicked,
        ActionsprevisionellesView,
        BesoinsCard
    },
    data() {

        return {
            formId: "besoins",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/besoins-Aggrid',
            table: 'besoins',
            projetsData: [],
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
            detailCellRenderer: null,
            projetId: 0,
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
            params['baseFilter']['projet_id'] = {values: [this.projetId], filterType: 'set'}
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
        this.url = this.axios.defaults.baseURL + '/api/besoins-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        console.log('voici les props passer au composants ==>', this.params)
        this.detailCellRenderer = "ActionsprevisionellesView"
        this.projetId = this.params.data.id


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
                    field: "evaluation",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'evaluation',
                },


                {
                    field: "creat_by",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'creat_by',
                },


                {
                    field: "valider",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'valider',
                },


                {
                    headerName: 'projet',
                    field: 'projet.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'projet',
                    field: 'projet_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['projet']['Selectlabel']
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
                            params.success(this.projetsData);
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
                        component: 'BesoinsCard',
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
                            valider: field => {
                                this.valider(field)
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
        this.projetsData = [this.params.data]

    },
    methods: {
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        valider(data) {
            this.isLoading = true
            let parentId = data.id
            data.valider = 1
            this.axios.post('/api/besoins/' + data.id + '/update', data).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
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
        getprojets() {
            this.axios.get('/api/projets').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.projetsData = response.data

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
.dataBlock {
    box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px;
    width: 98%;
    margin: 0 auto;
    padding: 10px;
    border: 1px solid #04040438;
    border-radius: 5px;
}

.createButton {
    position: absolute;
    z-index: 10000;
    right: 0;
    opacity: 0.5;
}

.createButton span {
    display: none
}

.createButton:hover {
    opacity: 1;
}

.createButton:hover span {
    display: inline-block;
}
</style>
