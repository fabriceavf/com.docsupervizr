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
                :modalFormId="formId"
                @close="closeForm"
            />


            <CreateTransactions
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
                    <div v-if="!$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i>
                        Nouveau
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateTransactions from './CreateTransactions.vue'
import EditTransactions from './EditTransactions.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'TransactionsView',
    components: {DataTable, AgGridTable, CreateTransactions, EditTransactions, DataModal, AgGridBtnClicked},
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
    },
    watch: {
        '$route': {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null)
                this.gridApi.refreshServerSide()
                this.tableKey++
            },
            deep: true
        },
    },
    created() {
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
                    field: "area_alias",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'area_alias',
                },


                {
                    field: "first_name",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'first_name',
                },


                {
                    field: "last_name",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'last_name',
                },


                {
                    field: "card_no",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'card_no',
                },


                {
                    field: "terminal_alias",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'terminal_alias',
                },


                {
                    field: "emp_code",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'emp_code',
                },


                {
                    field: "punch_date",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'punch_date',
                },


                {
                    field: "punch_time",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'punch_time',
                },


            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }


    },
    methods: {
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        closeForm() {
            this.tableKey++
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
    }
}
</script>
