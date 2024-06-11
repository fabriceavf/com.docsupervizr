<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Details {{ formData.id }}</div>
            </template>

            <div v-if="formState == 'Update'">
                <DetailDaysView :key="formData.id" :data="formData"></DetailDaysView>

            </div>


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <div class="col-sm-12">

            <AgGridTable :key="userSelect" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extras-data="extrasData" :maxBlocksInCache="maxBlocksInCache"
                         :pagination="pagination" :paginationPageSize="paginationPageSize"
                         :rowData="rowData"
                         :rowModelType="rowModelType" :showExport="false" :sideBar="false" :url="url"
                         className="ag-theme-alpine"
                         domLayout='autoHeight' rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>

                </template>

            </AgGridTable>
        </div>
    </div>
</template>


<script>
import AgGridTable from "@/components/AgGridTable.vue"
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
// import DaysTraitements from "./DaysTraitements.vue";
import DaysTraitements from "../Taches/Horaireagents/DaysTraitements.vue";
import TypeAgentsTraitements from "../Taches/Horaireagents/TypeAgentsTraitements.vue";
import DetailDaysView from "../Programmations/DetailDaysView.vue";

export default {
    name: 'historiquebadge',
    components: {AgGridTable, DaysTraitements, TypeAgentsTraitements, AgGridBtnClicked, DetailDaysView},
    props: {
        Type: String,
        weekselect: String,
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
            params['user_id'] = {values: [this.userSelect], filterType: 'set'}
            params['weekselect'] = {values: [this.weekselect], filterType: 'set'}
            return {baseFilter: params}


        },
        hideColumn() {
            return this.Type === 'BadgeUser'; // Remplacez 'valeur' par la valeur correspondante pour masquer la colonne
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
        this.url = this.axios.defaults.baseURL + '/api/programmes-Aggrid'

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
                    suppressCellSelection: true,
                    minWidth: 80, maxWidth: 80,
                    pinned: 'left',
                    cellRendererSelector: params => {
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api, "lg")
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },
                {
                    field: "debut_prevu",
                    minWidth: 120, maxWidth: 120,
                    sortable: true,
                    headerName: 'date ',
                    valueFormatter: params => {
                        let retour = params.value
                        try {
                            retour = params.value.split(' ')[0]
                        } catch (e) {

                        }
                        return retour
                    }
                },
                {
                    headerName: 'zone',
                    field: 'horaire.poste.site.zone.Selectlabel',
                    minWidth: 120, maxWidth: 120,
                },
                {
                    headerName: 'client',
                    field: 'horaire.poste.site.client.Selectlabel',
                },
                {
                    headerName: 'site',
                    field: 'horaire.poste.site.Selectlabel',
                },
                {
                    headerName: 'postes',
                    field: 'horaire.poste.Selectlabel',
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
