<template>
    <div class="row">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Update'">Update Utilisateurs #{{ formData.id }}</div>
                <div v-if="formState == 'Create'">Create Utilisateurs</div>
            </template>

            <!--      les formulaires des utilsateurs-->
            <EditUsers v-if="formState == 'Update'" :key="formKey" :actifsData="actifsData" :contratsData="contratsData"
                       :data="formData" :fonctionsData="fonctionsData" :gridApi="formGridApi"
                       :matrimonialesData="matrimonialesData" :modalFormId="formId" :nationalitesData="nationalitesData"
                       :onlinesData="onlinesData" :sexesData="sexesData" :typesData="typesData" :usersData="usersData"
                       @close="closeForm"/>
            <CreateUsers v-if="formState == 'Create'" :key="formKey" :actifsData="actifsData"
                         :contratsData="contratsData"
                         :fonctionsData="fonctionsData" :gridApi="formGridApi" :matrimonialesData="matrimonialesData"
                         :modalFormId="formId" :nationalitesData="nationalitesData" :onlinesData="onlinesData"
                         :sexesData="sexesData"
                         :typesData="typesData" :usersData="usersData" @close="closeForm"/>

            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>


        <div class="col-sm-12">


            <AgGridTable :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs"
                         :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                         :paginationPageSize="paginationPageSize"
                         :rowData="rowData" :rowModelType="rowModelType" :url="url" className="ag-theme-alpine"
                         domLayout='autoHeight' rowSelection="multiple" @gridReady="onGridReady">
                <template #header_buttons>
                    <div v-if="!$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate"><i
                        class="fa fa-plus"></i>
                        Ajouter un utilisateur
                    </div>
                </template>

            </AgGridTable>

        </div>
    </div>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateUsers from './CreateUsers.vue'
import EditUsers from './EditUsers.vue'
import DataModal from '@/components/DataModal.vue'
import CustomFiltre from "@/components/CustomFiltre.vue";
import moment from 'moment'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'UsersView',
    components: {DataTable, AgGridTable, CreateUsers, EditUsers, DataModal, AgGridBtnClicked, CustomFiltre},
    data() {

        return {
            defaultEntite: 'User',
            formId: "users",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/users-Aggrid',
            table: 'users',
            actifsData: [],
            contratsData: [],
            fonctionsData: [],
            matrimonialesData: [],
            nationalitesData: [],
            onlinesData: [],
            sexesData: [],
            typesData: [],
            usersData: [],
            requette: 9,
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
        $domaine: function () {
            let domaine = 'supervizr';
            try {
                domaine = window.domaine
            } catch (e) {
            }

            console.log('voila le domaine ==>', domaine)
            return domaine;
        },
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
            // this.url = 'http://127.0.0.1:8000/users-Aggrid'
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

    },
    beforeMount() {
        this.columnDefs = [
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

            {
                field: "nom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'nom',
            },

            {
                field: "prenom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'prenom',
            },
            {
                field: "role.name",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'profils',
            },
            {
                field: "email",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'email',
            },

            // {
            //
            //   headerName: 'fonction',
            //   field: 'fonction_id',
            //   valueFormatter: params => {
            //     let retour = ''
            //     try {
            //       return params.data['fonction']['Selectlabel']
            //     } catch (e) {
            //
            //     }
            //     return retour
            //   },
            //
            //   filter: 'agSetColumnFilter',
            //   filterParams: {suppressAndOrCondition: true,
            //     keyCreator: params => params.value.id,
            //     valueFormatter: params => params.value.Selectlabel,
            //     values: params => {
            //       params.success(this.fonctionsData);
            //     },
            //     refreshValuesOnOpen: true,
            //   },
            // },

            // {
            //
            //   headerName: 'contrat',
            //   field: 'contrat_id',
            //   valueFormatter: params => {
            //     let retour = ''
            //     try {
            //       return params.data['contrat']['Selectlabel']
            //     } catch (e) {
            //
            //     }
            //     return retour
            //   },
            //
            //   filter: 'agSetColumnFilter',
            //   filterParams: {suppressAndOrCondition: true,
            //     keyCreator: params => params.value.id,
            //     valueFormatter: params => params.value.Selectlabel,
            //     values: params => {
            //       params.success(this.contratsData);
            //     },
            //     refreshValuesOnOpen: true,
            //   },
            // },
            //
            // {
            //   field: "date_embauche",
            //   sortable: true,
            //  filter: 'agTextColumnFilter',filterParams: {suppressAndOrCondition: true,},
            //   headerName: 'date_embauche',
            //   valueFormatter: params => {
            //     let retour = params.value
            //     try {
            //       retour = params.value.split(' ')[0]
            //     } catch (e) {
            //
            //     }
            //     return retour
            //   }
            // },


            {
                field: "num_badge",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'numero de badge',
            },


            {

                headerName: 'sexe',
                field: 'sexe_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['sexe']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },
                filter: "CustomFiltre",
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/sexes-Aggrid',
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
        let defaultEntite = 'User'
        try {
            defaultEntite = this.$routeData.meta.defaultEntite
        } catch (e) {

        }
        this.defaultEntite = defaultEntite


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        // this.getactifs();
        // this.getcontrats();
        // this.getfonctions();
        // this.getmatrimoniales();
        // this.getnationalites();
        // this.getonlines();
        // this.getsexes();
        // this.gettypes();
        // this.getusers();

    },
    methods: {
        openCreate() {
            this.showForm('Create', {}, this.gridApi, 'xl')
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

    }
}
</script>
