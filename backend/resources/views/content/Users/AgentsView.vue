<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Agents #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Agents</div>
            </template>

            <EditAgents v-if="formState == 'Update'" :key="formKey" :actifsData="actifsData" :balisesData="balisesData"
                        :categoriesData="categoriesData" :contratsData="contratsData" :data="formData"
                        :directionsData="directionsData"
                        :echelonsData="echelonsData" :factionsData="factionsData" :fonctionsData="fonctionsData"
                        :gridApi="formGridApi"
                        :matrimonialesData="matrimonialesData" :modalFormId="formId"
                        :nationalitesData="nationalitesData"
                        :onlinesData="onlinesData" :postesData="postesData" :sexesData="sexesData"
                        :sitesData="sitesData"
                        :situationsData="situationsData" :typesData="typesData" :usersData="usersData"
                        :villesData="villesData"
                        :zonesData="zonesData" @close="closeForm"/>


            <CreateAgents v-if="formState == 'Create'" :key="formKey" :actifsData="actifsData"
                          :balisesData="balisesData"
                          :categoriesData="categoriesData" :contratsData="contratsData" :directionsData="directionsData"
                          :echelonsData="echelonsData" :factionsData="factionsData" :fonctionsData="fonctionsData"
                          :gridApi="formGridApi"
                          :matrimonialesData="matrimonialesData" :modalFormId="formId"
                          :nationalitesData="nationalitesData"
                          :onlinesData="onlinesData" :postesData="postesData" :sexesData="sexesData"
                          :sitesData="sitesData"
                          :situationsData="situationsData" :typesData="typesData" :usersData="usersData"
                          :villesData="villesData"
                          :zonesData="zonesData" @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="col-sm-12">
            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData" :rowModelType="rowModelType" :url="url" className="ag-theme-alpine"
                         domLayout='autoHeight'
                         rowSelection="multiple" @gridReady="onGridReady">
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
import CreateAgents from './CreateAgents.vue'
import EditAgents from './EditAgents.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'AgentsView',
    components: {DataTable, AgGridTable, CreateAgents, EditAgents, DataModal, AgGridBtnClicked},
    data() {

        return {
            formId: "users",
            formState: "",
            formData: {},
            formWidth: 'xl',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/users-Aggrid',
            table: 'users',
            actifsData: [],
            balisesData: [],
            categoriesData: [],
            contratsData: [],
            directionsData: [],
            echelonsData: [],
            factionsData: [],
            fonctionsData: [],
            matrimonialesData: [],
            nationalitesData: [],
            onlinesData: [],
            postesData: [],
            sexesData: [],
            sitesData: [],
            situationsData: [],
            typesData: [],
            usersData: [],
            villesData: [],
            zonesData: [],
            requette: 19,
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
                // 'nom',
            ]
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
        this.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
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
                                render: `<div class="" style="width:100%;height:100%;background:#ff8000;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`

                            }
                        };
                    },

                },


                // {
                //   field: "name",
                //   sortable: true,
                //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
                //   headerName: 'name',
                // },


                {
                    field: "nom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'nom',
                    hide: this.isShow('nom'),
                },


                {
                    field: "prenom",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'prenom',
                    hide: this.isShow('prenom'),
                },


                {
                    field: "matricule",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'matricule',
                    hide: this.isShow('matricule'),
                },


                {
                    field: "num_badge",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'badge',
                    hide: this.isShow('num_badge'),
                },


                {
                    field: "date_naissance",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'date de naissance',
                    hide: this.isShow('date_naissance'),
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
                    field: "num_cnss",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'cnss',
                    hide: this.isShow('num_cnss'),
                },


                {
                    field: "num_cnamgs",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'cnamgs',
                    hide: this.isShow('num_cnamgs'),
                },


                {
                    field: "telephone1",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'telephone',
                    hide: this.isShow('telephone1'),
                },


                {
                    field: "nombre_enfant",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'nombre_enfant',
                    hide: this.isShow('nombre_enfant'),
                },

                {
                    headerName: 'balise',
                    field: 'balise.Selectlabel',
                    hide: this.isShow('balise_id'),
                },
                {

                    headerName: 'balise',
                    field: 'balise_id',

                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['balise']['Selectlabel']
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
                            params.success(this.balisesData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },

                {
                    headerName: 'categorie',
                    field: 'categorie.Selectlabel',
                    hide: this.isShow('categorie_id'),
                },
                {

                    headerName: 'categorie',
                    field: 'categorie_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['categorie']['Selectlabel']
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
                            params.success(this.categoriesData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'contrat',
                    field: 'contrat.Selectlabel',
                    hide: this.isShow('contrat_id'),
                },
                {

                    headerName: 'contrat',
                    field: 'contrat_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['contrat']['Selectlabel']
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
                            params.success(this.contratsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'direction',
                    field: 'direction.Selectlabel',
                    hide: this.isShow('direction_id'),
                },
                {

                    headerName: 'direction',
                    field: 'direction_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['direction']['Selectlabel']
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
                            params.success(this.directionsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'echelon',
                    field: 'echelon.Selectlabel',
                    hide: this.isShow('echelon_id'),
                },
                {

                    headerName: 'echelon',
                    field: 'echelon_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['echelon']['Selectlabel']
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
                            params.success(this.echelonsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'faction',
                    field: 'faction.Selectlabel',
                    hide: this.isShow('faction_id'),
                },
                {

                    headerName: 'faction',
                    field: 'faction_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['faction']['Selectlabel']
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
                            params.success(this.factionsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'fonction',
                    field: 'fonction.Selectlabel',
                    hide: this.isShow('fonction_id'),
                },
                {

                    headerName: 'fonction',
                    field: 'fonction_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['fonction']['Selectlabel']
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
                            params.success(this.fonctionsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'matrimoniale',
                    field: 'matrimoniale.Selectlabel',
                    hide: this.isShow('matrimoniale_id'),
                },
                {

                    headerName: 'matrimoniale',
                    field: 'matrimoniale_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['matrimoniale']['Selectlabel']
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
                            params.success(this.matrimonialesData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'nationalite',
                    field: 'nationalite.Selectlabel',
                    hide: this.isShow('nationalite_id'),
                },
                {

                    headerName: 'nationalite',
                    field: 'nationalite_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['nationalite']['Selectlabel']
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
                            params.success(this.nationalitesData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'poste',
                    field: 'poste.Selectlabel',
                    hide: this.isShow('poste_id'),
                },
                {

                    headerName: 'poste',
                    field: 'poste_id',
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

                    filter: 'agSetColumnFilter',
                    filterParams: {
                        suppressAndOrCondition: true,
                        keyCreator: params => params.value.id,
                        valueFormatter: params => params.value.Selectlabel,
                        values: params => {
                            params.success(this.postesData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'sexe',
                    field: 'sexe.Selectlabel',
                    hide: this.isShow('sexe_id'),
                },
                {

                    headerName: 'sexe',
                    field: 'sexe_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['sexe']['Selectlabel']
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
                            params.success(this.sexesData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                // {
                //   headerName: 'site',
                //   field: 'site.Selectlabel',
                // },
                // {

                //   headerName: 'site',
                //   field: 'site_id',
                //   hide: true,
                //   suppressColumnsToolPanel: true,
                //   valueFormatter: params => {
                //     let retour = ''
                //     try {
                //       return params.data['site']['Selectlabel']
                //     } catch (e) {

                //     }
                //     return retour
                //   },

                //   filter: 'agSetColumnFilter',
                //   filterParams: {suppressAndOrCondition: true,
                //     keyCreator: params => params.value.id,
                //     valueFormatter: params => params.value.Selectlabel,
                //     values: params => {
                //       params.success(this.sitesData);
                //     },
                //     refreshValuesOnOpen: true,
                //   },
                // },


                {
                    headerName: 'situation',
                    field: 'situation.Selectlabel',
                    hide: this.isShow('situation_id'),
                },
                {

                    headerName: 'situation',
                    field: 'situation_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['situation']['Selectlabel']
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
                            params.success(this.situationsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'ville',
                    field: 'ville.Selectlabel',
                    hide: this.isShow('ville_id'),
                },
                {

                    headerName: 'ville',
                    field: 'ville_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['ville']['Selectlabel']
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
                            params.success(this.villesData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },


                {
                    headerName: 'zone',
                    field: 'zone.Selectlabel',
                    hide: this.isShow('zone_id'),
                },
                {

                    headerName: 'zone',
                    field: 'zone_id',
                    hide: true,
                    suppressColumnsToolPanel: true,
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['zone']['Selectlabel']
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
                            params.success(this.zonesData);
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

        // this.getactifs();
        // this.getbalises();
        // this.getcategories();
        // this.getcontrats();
        // this.getdirections();
        // this.getechelons();
        // this.getfactions();
        // this.getfonctions();
        // this.getmatrimoniales();
        // this.getnationalites();
        // this.getonlines();
        // this.getpostes();
        // this.getsexes();
        // this.getsites();
        // this.getpostes2();
        // this.getsituations();
        // this.gettypes();
        // this.getvilles();
        // this.getzones();

    },
    methods: {

        isShow(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            return this.champsAfficher.includes(fieldName) // si le champ existe return prend la valeur *true*
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        closeForm() {
            this.tableKey++
        },
        showForm(type, data, gridApi, width = 'xl') {
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
        getactifs() {
            this.axios.get('/api/actifs').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.actifsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getbalises() {
            this.axios.get('/api/balises').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.balisesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getcategories() {
            this.axios.get('/api/categories').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.categoriesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getcontrats() {
            this.axios.get('/api/contrats').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.contratsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getdirections() {
            this.axios.get('/api/directions').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.directionsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getechelons() {
            this.axios.get('/api/echelons').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.echelonsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getfactions() {
            this.axios.get('/api/factions').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.factionsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getfonctions() {
            this.axios.get('/api/fonctions').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.fonctionsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getmatrimoniales() {
            this.axios.get('/api/matrimoniales').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.matrimonialesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getnationalites() {
            this.axios.get('/api/nationalites').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.nationalitesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getonlines() {
            this.axios.get('/api/onlines').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.onlinesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getpostes() {
            this.axios.get('/api/postes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.postesData = response.data
                console.log('yannfiltreP=>', response.data)

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getsexes() {
            this.axios.get('/api/sexes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.sexesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        // getsites() {
        //   this.axios.get('/api/sites').then((response) => {
        //     this.requette--
        //     if (this.requette == 0) {
        //       // // this.$store.commit('setIsLoading', false)
        //     }
        //     this.sitesData = response.data

        //   }).catch(error => {
        //     console.log(error.response.data)
        //     // // this.$store.commit('setIsLoading', false)
        //     this.$toast.error('Erreur survenue lors de la récuperation')
        //   })
        // },

        getsites() {
            this.axios.get('/api/sites').then((response) => {
                // console.log('yannfiltre=>',response.data)
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                // console.log('yannfiltre=>', response.data)
                this.sitesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getsituations() {
            this.axios.get('/api/situations').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.situationsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        gettypes() {
            this.axios.get('/api/types').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.typesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
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

        getvilles() {
            this.axios.get('/api/villes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.villesData = response.data

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
