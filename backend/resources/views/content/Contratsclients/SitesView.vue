<template>

    <div class="row">
        <div class=" childBlock">
            <AgGridTable
                :key="tableKey"
                :cacheBlockSize="cacheBlockSize"
                :columnDefs="columnDefs"
                :detailCellRenderer="detailCellRenderer"
                :extrasData="extrasData"
                :inCard="false"
                :masterDetail="true"
                :maxBlocksInCache="maxBlocksInCache"
                :pagination="pagination"
                :paginationPageSize="paginationPageSize"
                :rowData="rowData"
                :rowModelType="rowModelType"
                :showExport="false"
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
import PostesView from './PostesView.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'SitesView',
    components: {DataTable, AgGridTable, DataModal, AgGridBtnClicked, PostesView},

    data() {

        return {
            formId: "sites",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/sites-Aggrid',
            table: 'sites',
            clientsData: [],
            zonesData: [],
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

            detailCellRenderer: null,
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
            let retour = {}
            let params = {}
            params['id'] = {values: this.params.data.AllSites, filterType: 'set'}
            retour['baseFilter'] = params

            return retour


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
        this.url = this.axios.defaults.baseURL + '/api/sites-Aggrid',
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
                    field: null,
                    headerName: '',
                    width: 10,

                    pinned: 'left',
                    cellRenderer: 'agGroupCellRenderer'
                },

                {
                    field: "libelle",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle du site',
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
                // {
                //     headerName: 'zone',
                //     field: 'zone.Selectlabel',
                // },
                // {
                //
                //     headerName: 'zone',
                //     field: 'zone_id',
                //     hide: true,
                //     suppressColumnsToolPanel: true,
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['zone']['Selectlabel']
                //         } catch (e) {
                //
                //         }
                //         return retour
                //     },
                //
                //     filter: 'agSetColumnFilter',
                //     filterParams: {
                //         suppressAndOrCondition: true,
                //         keyCreator: params => params.value.id,
                //         valueFormatter: params => params.value.Selectlabel,
                //         values: params => {
                //             params.success(this.zonesData);
                //         },
                //         refreshValuesOnOpen: true,
                //     },
                // },
                {
                    field: "NbrsJours",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Nbres Agents Jour',
                },
                {
                    field: "NbrsNuits",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Nbres Agents Nuit',
                },
                // {
                //     field: "created_at",
                //     sortable: true,
                //     filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                //     headerName: 'Créer le',
                //     valueFormatter: params => {
                //         let retour = params.value
                //         try {
                //             retour = moment(params.value).format('DD/MM/YYYY à HH:mm')
                //         } catch (e) {
                //
                //         }
                //         return retour
                //     }
                // },

            ];


    },
    mounted() {
        this.detailCellRenderer = 'PostesView'
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        console.log('voici les params ,', this.params)

        // this.getclients();
        // this.getzones();

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

            console.log('on demarre les sites', params)
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false
            this.gridApi.sizeColumnsToFit();
            this.gridApi._ContratsclientId = this.params.data.id

        },
        getclients() {
            this.axios.get('/api/clients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.clientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getzones() {
            this.axios.get('/api/zones').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.zonesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

    }
}
</script>
<style>
.ag-root-wrapper {
    border-radius: 5px
}

.childBlock {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 95%;
    margin: 10px auto;
}

.newButton {
    text-align: center;
    margin: 0 auto;
    position: absolute;
    top: 15px;
    right: 30px;
    border-radius: 5px;
    padding: 10px;
    background: #0004ff;
    color: #fff;
}
</style>
