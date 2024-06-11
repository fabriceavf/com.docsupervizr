<template>

    <div class="row">

        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Cruds #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Cruds</div>
            </template>

            <EditCruds
                v-if="formState=='Update'"
                :key="formKey"
                :data="formData"
                :gridApi="formGridApi"
                :modalFormId="formId"
                :usersData="usersData"
                @close="closeForm"
            />


            <CreateCruds
                v-if="formState=='Create'"
                :key="formKey"
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
                :key="userSelect"
                :cacheBlockSize="cacheBlockSize"
                :columnDefs="columnDefs"
                :extras-data="extrasData"
                :in-card="false"
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
import EditCruds from '@/views/content/Cruds/EditCruds.vue'
import moment from 'moment'


import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'Activitesrecentes',
    components: {DataTable, AgGridTable, DataModal, AgGridBtnClicked, AdminPerms, EditCruds},
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
            url: 'http://127.0.0.1:8000/api/historiques-Aggrid',
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
            params['cle'] = {values: [this.userSelect], filterType: 'set'}
            params['type'] = {values: ['listings'], filterType: 'set'}

            if (this.search !== "") {
                params['filterFields'] = ['action'];
                params['globalSearch'] = this.search;
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

        this.url = this.axios.defaults.baseURL + '/api/historiques-Aggrid',
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
                    field: "valeur",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Action',
                },
                {
                    field: "created_at",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Créer le',
                    valueFormatter: params => {
                        let retour = params.value
                        try {
                            retour = moment(params.value).format('DD/MM/YYYY à HH:mm')
                        } catch (e) {

                        }
                        return retour
                    }
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
