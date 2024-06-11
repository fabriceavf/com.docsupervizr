<template>
    <div class="row">

        <div class="col-sm-12">

            <AgGridTable :key="userSelect" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extras-data="extrasData"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData" :rowModelType="rowModelType" :showExport="false"
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
// import DaysTraitements from "./DaysTraitements.vue";
import DaysTraitements from "../Taches/Horaireagents/DaysTraitements.vue";
import TypeAgentsTraitements from "../Taches/Horaireagents/TypeAgentsTraitements.vue";

export default {
    name: 'historiquebadge',
    components: {AgGridTable, DaysTraitements, TypeAgentsTraitements, AgGridBtnClicked},
    props: {
        Type: String,
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
            if (this.Type === 'BadgeUser') {
                params['user_id'] = {values: [this.userSelect], filterType: 'set'}
                // params['type'] = {values: [this.Type], filterType: 'set'}

                if (this.search !== "") {
                    params['filterFields'] = ['action'];
                    params['globalSearch'] = this.search;
                }
            } else {
                params['user_id'] = {values: [this.userSelect], filterType: 'set'}
                params['type'] = {values: ['ficheAgents'], filterType: 'set'}
            }
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
        this.url = this.axios.defaults.baseURL + '/api/horaireagents-Aggrid'

        if (this.Type === 'BadgeUser') {
            // this.url = this.axios.defaults.baseURL + '/api/historiques-Aggrid';
            this.url = this.axios.defaults.baseURL + '/api/assignations-Aggrid';
        }
        ;
        this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        this.days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        this.typeAgents = ['Type Agents'];

    },
    beforeMount() {
        if (this.Type === 'BadgeUser') {
            this.columnDefs =
                [


                    {
                        field: "carte.Selectlabel",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'Badge',
                        hide: !this.hideColumn,
                    },

                    {
                        headerName: 'Poste',
                        field: 'valeur',
                        hide: this.hideColumn,
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
                        field: "debut",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'Attribuer le',
                        valueFormatter: params => {
                            let retour = params.value
                            try {
                                if (retour) {
                                    retour = moment(params.value).format('DD/MM/YYYY à HH:mm')

                                } else {
                                    retour = 'Date inconnue'
                                }
                            } catch (e) {

                            }
                            return retour
                        }
                    },


                    {
                        field: "fin",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'Rettirer le',
                        valueFormatter: params => {
                            let retour = params.value
                            try {
                                if (retour) {
                                    retour = moment(params.value).format('DD/MM/YYYY à HH:mm')

                                } else {
                                    retour = 'Date inconnue'
                                }
                            } catch (e) {

                            }
                            return retour
                        }
                    },


                ];
        } else {
            this.columnDefs =
                [


                    {
                        field: "horaire.poste.Selectlabel",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'postes',
                    },
                    {
                        field: "horaire.poste.site.Selectlabel",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'Sites',
                    },

                    {
                        field: "horaire.poste.site.zone.Selectlabel",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'Zones',
                    },
                    {
                        field: "horaire.poste.site.client.Selectlabel",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'Clients',
                    },
                    {
                        field: "horaire.type",
                        sortable: true,
                        filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                        headerName: 'factions',
                    },
                ];
            this.typeAgents.forEach(day => {
                let donnes = {
                    field: day,
                    suppressCellSelection: true,
                    minWidth: 250,
                    maxWidth: 250,
                    cellRendererSelector: (params) => {
                        return {
                            component: "TypeAgentsTraitements",
                            params: {
                                dropdownOptions: [
                                    {value: 1, label: 'Titulaire'},
                                    {value: 2, label: 'Remplacant'},
                                    {value: 3, label: 'Conge'},
                                    // ... Ajoutez d'autres options si nécessaire
                                ],
                                disabled: 0,
                            },
                        };

                    },
                    headerName: day,
                }
                this.columnDefs.push(donnes)
            })
            this.days.forEach(day => {
                let donnes = {
                    field: day,
                    suppressCellSelection: true,
                    maxminWidth: 80,
                    maxWidth: 80,
                    cellRendererSelector: (params) => {
                        return {
                            component: "DaysTraitements",
                            params: {
                                day: day,
                                disabled: 0,
                            },
                        };

                    },
                    headerName: day[0],
                }
                this.columnDefs.push(donnes)
            })


        }


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
