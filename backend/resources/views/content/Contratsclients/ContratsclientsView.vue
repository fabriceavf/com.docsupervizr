<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Contratsclients #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Contratsclients</div>
            </template>

            <EditContratsclients
                v-if="formState=='Update'"
                :key="formKey"
                :clientsData="clientsData"
                :data="formData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                @close="closeForm"
            />


            <CreateContratsclients
                v-if="formState=='Create'"
                :key="formKey"
                :clientsData="clientsData"
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
                :masterDetail="true"
                :maxBlocksInCache="maxBlocksInCache"
                :pagination="pagination"
                :paginationPageSize="paginationPageSize"
                :rowData="rowData"
                :rowHeight="50"
                :rowModelType="rowModelType"
                :url="url"
                className="ag-theme-alpine"
                domLayout='autoHeight'
                rowSelection="multiple"
                @gridReady="onGridReady"
                @first-data-rendered="onFirstDataRendered"

            >
                <template #header_buttons>
                    <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
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
import CreateContratsclients from './CreateContratsclients.vue'
import EditContratsclients from './EditContratsclients.vue'
import DataModal from '@/components/DataModal.vue'
import Details from "./Details.vue";
import CustomFiltre from "@/components/CustomFiltre.vue";
import SitesView from "./SitesView.vue";


import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ContratsclientsView',
    components: {
        DataTable,
        AgGridTable,
        CreateContratsclients,
        EditContratsclients,
        DataModal,
        AgGridBtnClicked,
        Details,
        SitesView,
        CustomFiltre
    },
    data() {

        return {
            formId: "contratsclients",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/contratsclients-Aggrid',
            table: 'contratsclients',
            clientsData: [],
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
        this.url = this.axios.defaults.baseURL + '/api/contratsclients-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        this.detailCellRenderer = 'SitesView';

    },
    beforeMount() {
        this.columnDefs =
            [
                // {
                //     field: null,
                //     headerName: '',
                //     width: 10,
                //
                //     pinned: 'left',
                //     cellRenderer: 'agGroupCellRenderer'
                // },
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
                //                     this.showForm('Update', field, params.api)
                //                 },
                //                 render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                //             }
                //         };
                //     },
                //
                // },


                {
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                    cellRenderer: 'agGroupCellRenderer'
                },


                // {
                //     field: "description",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'description',
                // },


                {
                    headerName: 'client',
                    field: 'client.Selectlabel',
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

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getclients();

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
        getclients() {
            this.axios.get('/api/clients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.clientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

    }
}
</script>
