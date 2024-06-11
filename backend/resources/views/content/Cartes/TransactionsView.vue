<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Transactions #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Transactions</div>
            </template>

            <EditTransactions
                v-if="formState=='Update'"
                :key="formKey"
                :data="formData"
                :gridApi="formGridApi"
                :lignesData="lignesData"
                :modalFormId="formId"
                :terminalsData="terminalsData"
                @close="closeForm"
            />


            <CreateTransactions
                v-if="formState=='Create'"
                :key="formKey"
                :gridApi="formGridApi"
                :lignesData="lignesData"
                :modalFormId="formId"
                :terminalsData="terminalsData"
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
                :maxBlocksInCache="maxBlocksInCache"
                :pagination="pagination"
                :paginationPageSize="paginationPageSize"
                :rowData="rowData"
                :rowModelType="rowModelType"
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
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CustomSelect from "@/components/CustomSelect.vue"
import CustomFiltre from "@/components/CustomFiltre.vue"
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'TransactionsView',
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked,
        CustomSelect,
        CustomFiltre
    },
    props: {
        carte: {
            default: 0
        }
    },
    data() {

        return {
            formId: "transactions",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/transactions-Aggrid',
            table: 'transactions',
            lignesData: [],
            terminalsData: [],
            requette: 2,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 10,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
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
            let retour = {};
            let params = {};
            if (this.carte) {
                params['card_no'] = {values: [this.carte], filterType: "set"};

            } else {

            }
            retour["baseFilter"] = params;

            return retour;
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
        // this.url = this.axios.defaults.baseURL + '/useCase?action=AggridTransaction',
        this.url = this.axios.defaults.baseURL + '/api/transactions-Aggrid',
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
                    field: "punch_time",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'punch_time',
                },

                {
                    field: "card_no",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'carte',
                },

                {
                    field: "cout",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'cout',
                },

                {
                    field: "etats",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'etats',
                },

                {
                    field: "type",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'status',
                },


                {
                    headerName: 'ligne',
                    field: 'ligne.Selectlabel',
                },

                {

                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'ligne',
                    field: 'ligne_id',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['ligne']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },

                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/lignes-Aggrid',
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
                    headerName: 'terminal',
                    field: 'pointeuse.Selectlabel',
                },
                {

                    headerName: 'pointeuse',
                    field: 'pointeuse_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['pointeuse']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/pointeuses-Aggrid',
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

        this.getlignes();
        this.getterminals();

    },
    methods: {
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
        },
        getlignes() {
            this.axios.get('/api/lignes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.lignesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getterminals() {
            this.axios.get('/api/terminals').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.terminalsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

    }
}
</script>
