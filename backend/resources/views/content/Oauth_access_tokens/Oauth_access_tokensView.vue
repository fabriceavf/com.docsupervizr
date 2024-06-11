<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Oauth_access_tokens #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Oauth_access_tokens</div>
            </template>

            <EditOauth_access_tokens
                v-if="formState=='Update'"
                :key="formKey"
                :clientsData="clientsData"
                :data="formData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :usersData="usersData"
                @close="closeForm"
            />


            <CreateOauth_access_tokens
                v-if="formState=='Create'"
                :key="formKey"
                :clientsData="clientsData"
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
import CreateOauth_access_tokens from './CreateOauth_access_tokens.vue'
import EditOauth_access_tokens from './EditOauth_access_tokens.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'Oauth_access_tokensView',
    components: {
        DataTable,
        AgGridTable,
        CreateOauth_access_tokens,
        EditOauth_access_tokens,
        DataModal,
        AgGridBtnClicked
    },
    data() {

        return {
            formId: "oauth_access_tokens",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/oauth_access_tokens-Aggrid',
            table: 'oauth_access_tokens',
            clientsData: [],
            usersData: [],
            requette: 2,
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
        this.url = this.axios.defaults.baseURL + '/api/oauth_access_tokens-Aggrid',
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
                    field: "name",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'name',
                },


                {
                    field: "scopes",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'scopes',
                },


                {
                    field: "revoked",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'revoked',
                },


                {
                    field: "expires_at",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'expires_at',
                },


                {
                    headerName: 'client',
                    field: 'client.Selectlabel',
                },
                {

                    headerName: 'client',
                    field: 'client_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['client']['Selectlabel']
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
                            params.success(this.clientsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'user',
                    field: 'user.Selectlabel',
                },
                {

                    headerName: 'user',
                    field: 'user_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['user']['Selectlabel']
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
                            params.success(this.usersData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getclients();
        // this.getusers();

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

    }
}
</script>
