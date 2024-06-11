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
                    <div v-if="$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> Ajouter un contrat
                    </div>
                    <input v-model="month" class="form-control" placeholder="Veuillez selectioner le mois"
                           style="width: auto !important" type="month"/>
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
    props: ['zoneselectionner'],
    data() {

        return {
            month: null,
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
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != "undefined") {
                    router = window.routeData;
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
            let params = {};
            // if (!this.month) {
            //     params["id"] = {values: [0], filterType: "set"};
            // }
            this.tableKey++;

            return {
                // month: this.month,
                zoneselectionner: this.zoneselectionner,
            };
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

        month: {
            handler: function (after, before) {
                console.log('okk', after, before)
                let inputUrl = new URL(window.location.href);
                inputUrl.searchParams.delete('month')
                inputUrl.searchParams.append('month', after)
                if (before) {
                    window.location.href = inputUrl.href
                }
                if (after == this.month) {
                    console.log('okk4', after, before, this.month)
                }
            },
            deep: true,
        },
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/postes-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        this.detailCellRenderer = 'Details';
        // this.detailCellRendererParams = {'parentId': parentId} ;
        this.detailCellRendererParams = {week: this.week};
    },
    beforeMount() {
        this.columnDefs =
            [


                {
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                    cellRenderer: 'agGroupCellRenderer'
                },


                // {
                //         field: "libelle",
                //         sortable: true,
                //         filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //         headerName: 'libelle',
                //         pinned: 'left',
                //         width: 200,
                //     },
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
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/clients-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["Selectlabel"]}`;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['libelle'],
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
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/sites-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["Selectlabel"]}`;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['libelle'],
                    },
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
                    filter: "FiltreEntete",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/zones-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["Selectlabel"]}`;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['libelle'],
                    },
                },
            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        this.month = this.$routeData.meta.months

    },
    methods: {
        onFirstDataRendered(params) {
            params.api.setGridOption("rowData", this.month);
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
            // this.columnApi = params.columnApi;
            this.isLoading = false
            this.gridApi.sizeColumnsToFit();
        },

    }
}
</script>
