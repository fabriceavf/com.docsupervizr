<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Lignesmoyenstransports #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Lignesmoyenstransports</div>
            </template>

            <EditLignesmoyenstransports v-if="formState == 'Update'" :key="formKey" :data="formData"
                                        :gridApi="formGridApi"
                                        :lignesData="lignesData" :modalFormId="formId"
                                        :moyenstransportsData="moyenstransportsData"
                                        :parentId="parentId"
                                        @close="closeForm"/>


            <CreateLignesmoyenstransports v-if="formState == 'Create'" :key="formKey" :gridApi="formGridApi"
                                          :lignesData="lignesData" :modalFormId="formId"
                                          :moyenstransportsData="moyenstransportsData"
                                          :parentId="parentId"
                                          @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :extrasData="extrasData"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize" :rowData="rowData"
                         :rowModelType="rowModelType" :url="url"
                         className="ag-theme-alpine" domLayout='autoHeight' rowSelection="multiple"
                         @gridReady="onGridReady">
                <template #header_buttons>
                    <div v-if="!routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i> Nouveau
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateLignesmoyenstransports from './CreateLignesmoyenstransports.vue'
import EditLignesmoyenstransports from './EditLignesmoyenstransports.vue'
import CustomSelect from "@/components/CustomSelect.vue"
import CustomFiltre from "@/components/CustomFiltre.vue"
import DataModal from '@/components/DataModal.vue'
import DaysTraitements from "./DaysTraitements.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'LignesmoyenstransportsView',
    components: {
        DataTable,
        AgGridTable,
        DaysTraitements,
        CreateLignesmoyenstransports,
        EditLignesmoyenstransports,
        DataModal,
        AgGridBtnClicked,
        CustomSelect,
        CustomFiltre
    },
    props: ['parentId'
    ],
    data() {

        return {
            formId: "lignesmoyenstransports",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/lignesmoyenstransports-Aggrid',
            table: 'lignesmoyenstransports',
            lignesData: [],
            moyenstransportsData: [],
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
            let params = {baseFilter: {}}
            params['baseFilter']['moyenstransport_id'] = {values: [this.parentId], filterType: 'set'}
            return params


        },
        days: function () {
            return ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']
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
        this.url = this.axios.defaults.baseURL + '/api/lignesmoyenstransports-Aggrid',
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
                    width: 80,
                    pinned: 'left',
                    cellRendererSelector: params => {
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                clicked: field => {
                                    this.showForm('Update', field, params.api)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-raduis:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },


                {
                    field: "heure_debut",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'heure_debut',
                },


                {
                    field: "heure_fin",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'heure_fin',
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


            ];
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
                        },
                    };

                },
                headerName: day[0],
            }
            this.columnDefs.push(donnes)
        })


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        this.getlignes();
        this.getmoyenstransports();

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

        getmoyenstransports() {
            this.axios.get('/api/moyenstransports').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.moyenstransportsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

    }
}
</script>
