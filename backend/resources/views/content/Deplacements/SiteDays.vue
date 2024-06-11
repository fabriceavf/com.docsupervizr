<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>

            </template>


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :detailCellRenderer="detailCellRenderer" :detailCellRendererParams="detailCellRendererParams"
                         :extrasData="extrasData" :masterDetail="true"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData" :rowHeight="50" :rowModelType="rowModelType" :url="url"
                         className="ag-theme-alpine"
                         domLayout='autoHeight' rowSelection="multiple" @gridReady="onGridReady"
                         @first-data-rendered="onFirstDataRendered">

                <template #header_buttons>
                    <div v-if="routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> Ajouter un contrat
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"

import DataModal from '@/components/DataModal.vue'
import Details from "./Details.vue";
import CustomFiltre from "@/components/CustomFiltre.vue";
import AgentsrapportsView from "../Agentsrapports/AgentsrapportsView.vue";


import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ContratsclientsView',
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked,
        Details,
        AgentsrapportsView,
        CustomFiltre
    },
    props: ['parentDate', 'parentId'],
    data() {

        return {
            formId: "agentsPostes",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/agentsPostes-Aggrid',
            table: 'agentsPostes',
            clientsData: [],
            requette: 1,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            parentId: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            detailCellRenderer: null,
            detailCellRendererParams: null,
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
            params['deplacement_id'] = {values: [this.parentId], filterType: 'set'}
            params['date'] = {values: [this.parentDate], filterType: 'set'}
            return {baseFilter: params}


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
        this.url = this.axios.defaults.baseURL + '/api/sitessdeplacements-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        this.detailCellRenderer = 'Details';
        // this.detailCellRendererParams = {'parentId': parentId} ;
        // this.detailCellRendererParams = {parentId: '100'};
    },
    beforeMount() {
        this.columnDefs =
            [


                {
                    field: "site.Selectlabel",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'site',
                    // cellRenderer: 'agGroupCellRenderer'
                },

                {
                    field: "durees",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'duree',
                    // cellRenderer: 'agGroupCellRenderer'
                },
                // {
                //         field: "libelle",
                //         sortable: true,
                //         filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //         headerName: 'libelle',
                //         pinned: 'left',
                //         width: 200,
                //     },
                // {
                //     headerName: 'ville',
                //     field: 'ville.Selectlabel',
                // },
                // {

                //     hide: true,
                //     suppressColumnsToolPanel: true,

                //     headerName: 'ville',
                //     field: 'ville_id',
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['ville']['Selectlabel']
                //         } catch (e) {

                //         }
                //         return retour
                //     },

                //     filter: "CustomFiltre",
                //     filterParams: {
                //         url: this.axios.defaults.baseURL + '/api/villes-Aggrid',
                //         columnDefs: [
                //             {
                //                 field: "",
                //                 sortable: true,
                //                 filter: "agTextColumnFilter",
                //                 filterParams: {suppressAndOrCondition: true},
                //                 headerName: "",
                //                 cellStyle: {fontSize: '11px'},
                //                 valueFormatter: (params) => {
                //                     let retour = "";
                //                     try {
                //                         return `${params.data["Selectlabel"]}`;
                //                     } catch (e) {
                //                     }
                //                     return retour;
                //                 },
                //             },
                //         ],
                //         filterFields: ['libelle'],
                //     },
                // },

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }


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

    }
}
</script>
