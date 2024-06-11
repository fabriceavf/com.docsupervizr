<template>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group col-12">
                <input v-model.lazy="search" class="form-control" type="text">
            </div>
            <AgGridTable
                :key="userSelect"
                :cacheBlockSize="cacheBlockSize"
                :columnDefs="columnDefs"
                :extras-data="extrasData"
                :in-card="false"
                :maxBlocksInCache="maxBlocksInCache"
                :pagination="pagination"
                :paginationPageSize="paginationPageSize"
                :rowData="rowData"
                :rowHeight="50"
                :rowModelType="rowModelType"
                :sideBar="false"
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
import DataModal from '@/components/DataModal.vue'
import AdminPerms from "@/views/content/Users/AdminPerms.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'PermsView',
    components: {DataTable, AgGridTable, DataModal, AgGridBtnClicked, AdminPerms},
    props: {
        userSelect: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            search: "",
            formId: "perms",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/perms-Aggrid',
            table: 'perms',
            usersData: [],
            requette: 1,
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
            let params = {}
            params['user_id'] = {values: [this.userSelect], filterType: 'set'}
            if (this.search !== "") {
                params['permission_label'] = {filter: this.search, filterType: 'text', type: 'contains'}
            }
            return {baseFilter: params}


        }
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
        'extrasData': {
            handler: function (after, before) {

                this.gridApi.sizeColumnsToFit();
                this.gridApi.refreshServerSide()
            },
            deep: true
        },
    },
    created() {

        this.url = this.axios.defaults.baseURL + '/api/perms-Aggrid',
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
                //     field: "permission_label",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'permission',
                // },

                {
                    field: "type",
                    headerName: 'Etats',
                    cellRendererSelector: params => {
                        params.api.sizeColumnsToFit();
                        return {
                            component: 'AdminPerms',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },

                            }
                        };
                    },
                    maxWidth: 100
                },
                {
                    headerName: 'Permission',
                    field: 'Selectlabel',
                }


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
                    // // this.$store.commit('setIsLoading', false)
                }
                this.usersData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

    }
}
</script>
