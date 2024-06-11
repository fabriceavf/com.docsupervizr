<template>
    <div class="row">

        <div class="col-sm-12">

            <AgGridTable :key="pointeuseSelect" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extras-data="extrasData" :in-card="false" :maxBlocksInCache="maxBlocksInCache"
                         :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData" :rowModelType="rowModelType"
                         :sideBar="false"
                         :url="url" className="ag-theme-alpine" domLayout='autoHeight' rowSelection="multiple"
                         @gridReady="onGridReady">
                <template #header_buttons>

                </template>

            </AgGridTable>
        </div>
    </div>
</template>


<script>
import AgGridTable from "@/components/AgGridTable.vue"

import moment from 'moment'
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'historiqueposte',
    components: {AgGridTable, AgGridBtnClicked},
    props: {
        Type: String,
        pointeuseSelect: {
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
            params['cle'] = {values: [this.pointeuseSelect], filterType: 'set'}
            params['type'] = {values: [this.Type], filterType: 'set'}

            if (this.search !== "") {
                params['filterFields'] = ['action'];
                params['globalSearch'] = this.search;
            }
            return {baseFilter: params}


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
                    headerName: 'Poste',
                    field: 'poste.Selectlabel',
                },
                {

                    headerName: 'poste',
                    field: 'valeur',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['poste']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                },

                {
                    field: "created_at",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Attribuer le',
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

    }
}
</script>
