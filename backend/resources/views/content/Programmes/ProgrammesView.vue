<template>

    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Update'">Update Programmes #{{ formData.id }}</div>
                <div v-if="formState=='Create'">Create Programmes</div>
            </template>

            <!--            <EditProgrammes-->
            <!--                v-if="formState=='Update'"-->
            <!--                :modalFormId="formId"-->
            <!--                :key="formKey"-->
            <!--                :data="formData"-->
            <!--                :gridApi="formGridApi"-->
            <!--                @close="closeForm"-->
            <!--                :horairesData="horairesData"-->
            <!--                :programmationsusersData="programmationsusersData"-->
            <!--            />-->
            <DetailDaysView
                v-if="formState=='Update'"
                :key="formKey"
                :data="formData"
                :gridApi="formGridApi"
                :horairesData="horairesData"
                :modalFormId="formId"
                :programmationsusersData="programmationsusersData"
                :typesabscencesData="typesabscencesData"
                @close="closeForm"
            />


            <CreateProgrammes
                v-if="formState=='Create'"
                :key="formKey"
                :gridApi="formGridApi"
                :horairesData="horairesData"
                :modalFormId="formId"
                :programmationsusersData="programmationsusersData"
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
                    <!--                    <div class="btn btn-primary" v-if="!routeData.meta.hideCreate" @click="openCreate"><i-->
                    <!--                        class="fa fa-plus"></i> Nouveau-->
                    <!--                    </div>-->
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateProgrammes from './CreateProgrammes.vue'
import EditProgrammes from './EditProgrammes.vue'
import DataModal from '@/components/DataModal.vue'
import CustomFiltre from "@/components/CustomFiltre.vue";
import DetailDaysView from "../Programmations/DetailDaysView.vue";

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'ProgrammesView',
    components: {
        DataTable,
        AgGridTable,
        CreateProgrammes,
        EditProgrammes,
        DataModal,
        AgGridBtnClicked,
        DetailDaysView,
        CustomFiltre
    },
    data() {

        return {
            programme: {},
            formId: "programmes",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/programmes-Aggrid',
            table: 'programmes',
            horairesData: [],
            typesabscencesData: [],
            programmationsusersData: [],
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
            champsAfficher: [
                //LISTE DES CHAMP à MASQUER
                'programmationsuser',
                'etats',
                'identifiants_sadge',
                'horaire',

            ]
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
        this.url = this.axios.defaults.baseURL + '/api/programmes-Aggrid',
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
                                    // this.programme=
                                    // console.log('voici le programme ==>', params.data)
                                    this.showForm('Update', field, params.api)
                                },
                                render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            }
                        };
                    },

                },

                {
                    field: "debut_prevu",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'debut prevu',
                },


                {
                    field: "fin_prevu",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'fin prevu',
                },

                {
                    headerName: 'Nom',
                    field: 'user.nom',
                    sortable: false,
                },

                {
                    headerName: 'Prenom',
                    field: 'user.prenom',
                    sortable: false,
                },
                {
                    headerName: 'Matricule',
                    field: 'user.matricule',
                    sortable: false,
                },
                {
                    headerName: 'Nbrs Pts Reel',
                    field: 'totalReel',
                },
                {
                    field: "volume_horaire",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'volume_horaire',
                },


                {
                    field: "debut_realise",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'debut_realise',
                },
                {
                    field: "fin_realise",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'fin_realise',
                },
                {
                    headerName: 'horaire',
                    field: 'horaire.Selectlabel',
                    hide: this.isShow('horaire'),
                    suppressColumnFilter: this.isShow('horaire'),
                },

            ];


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.gethoraires();
        // this.gettypesabscences();
        // this.getprogrammationsusers();

    },
    methods: {
        isShow(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            return this.champsAfficher.includes(fieldName) // si le champ existe return prend la valeur *true*
        },
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
        gethoraires() {
            this.axios.get('/api/horaires').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.horairesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        gettypesabscences() {
            this.axios.get('/api/typesabscences').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.typesabscencesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getprogrammationsusers() {
            this.axios.get('/api/programmationsusers').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.programmationsusersData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

    }
}
</script>
